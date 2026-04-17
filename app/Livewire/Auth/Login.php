<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\ResearchAnalytic;
use Livewire\Component;
use Illuminate\Support\Facades\{Http, Auth, DB, Hash, Log};
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class Login extends Component
{
    public $username, $password;

    public function login()
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $apiUrl = env('KAMPUS_API_URL'); // Pastikan di .env isinya: https://sains.universitaspahlawan.ac.id/api
        $ssoSuccess = false;
        $loginData = null;

        // 1. COBA LOGIN VIA SSO KAMPUS
        try {
            if ($apiUrl) {
                $response = Http::withoutVerifying()->timeout(10)->post("{$apiUrl}/login", [
                    'username' => $this->username,
                    'password' => $this->password,
                ]);

                if ($response->successful()) {
                    $loginData = $response->json();
                    if (($loginData['isSuccess'] ?? 0) == 200) {
                        $ssoSuccess = true;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::warning('SSO Auth Timeout: ' . $e->getMessage());
            // API mati, biarkan jatuh ke proses Local Auth di bawah
        }

        // JIKA KREDENSIAL SSO BENAR, LANJUTKAN TARIK DATA
        if ($ssoSuccess) {
            return $this->handleSSOLogin($loginData, $apiUrl);
        }

        // 2. JIKA SSO GAGAL (API Down / Belum Bayar UKT), COBA LOCAL AUTH
        if ($this->attemptLocalLogin()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        // 3. JIKA GAGAL TOTAL
        $this->dispatch('swal:alert', [
            'icon' => 'error',
            'title' => 'Login Failed',
            'text' => 'Invalid username/NIM or password!',
        ]);
    }

    private function handleSSOLogin($loginData, $apiUrl)
    {
        $originalRole = strtolower($loginData['role'] ?? 'mahasiswa');
        $token = $loginData['token'] ?? null;

        if (!$token) {
            return $this->fallbackToLocalAccount('Invalid SSO response from campus server.');
        }

        try {
            // Ambil Detail Profil Mahasiswa/Dosen/Pegawai
            $detailRes = Http::withoutVerifying()
                ->withToken($token)
                ->timeout(10)
                ->get("{$apiUrl}/{$originalRole}", [
                    'username' => $this->username
                ]);

            // Cek apakah response dari API sukses dan nilai "respon" adalah "true"
            if ($detailRes->successful() && $detailRes->json('respon') == 'true') {
                $detailData = $detailRes->json('data');

                // Mapping Nomor Induk (NIM / NIDN / NIP) sesuai Role
                $nimNip = $this->username; // Default fallback
                if ($originalRole === 'mahasiswa' && isset($detailData['nim'])) {
                    $nimNip = $detailData['nim'];
                } elseif ($originalRole === 'dosen' && isset($detailData['nidn'])) {
                    $nimNip = $detailData['nidn'];
                } elseif ($originalRole === 'pegawai' && isset($detailData['nip'])) {
                    $nimNip = $detailData['nip'];
                }

                // Mengakali Email Kosong dari API
                $apiEmail = $loginData['email'] ?? '';
                $safeEmail = !empty($apiEmail) ? $apiEmail : $this->username . '@universitaspahlawan.ac.id';

                // SINKRONISASI DATABASE LOKAL
                DB::transaction(function () use ($loginData, $detailData, $originalRole, $token, $nimNip, $safeEmail) {

                    $user = User::updateOrCreate(
                        ['username' => $this->username], // Cari berdasarkan username
                        [
                            'name'     => $detailData['nama'] ?? $this->username,
                            'nim_nip'  => $nimNip,
                            'email'    => $safeEmail,
                            'password' => Hash::make($this->password), // Simpan agar bisa login lokal jika API down besok
                        ]
                    );

                    // Inisialisasi Analitik Riset jika belum ada
                    ResearchAnalytic::firstOrCreate(['user_id' => $user->id]);

                    // Atur Peran (Roles)
                    if (!Role::where('name', $originalRole)->exists()) Role::create(['name' => $originalRole]);
                    if (!Role::where('name', 'admin')->exists()) Role::create(['name' => 'admin']);

                    if (!$user->hasRole($originalRole)) {
                        $user->assignRole($originalRole);
                    }

                    // Bypass Khusus Peneliti (Admin)
                    if ($this->username == '1855201011' && !$user->hasRole('admin')) {
                        $user->assignRole('admin');
                    }

                    session(['api_token' => $token]);
                    Auth::login($user);
                });

                Alert::success('Login Success', 'Welcome to LitFlow! 🎉');
                return $this->redirectBasedOnRole(Auth::user());
            } else {
                Log::warning("Profile Fetch Failed (Bad Response) for {$this->username}");
                return $this->fallbackToLocalAccount("Failed to retrieve profile data from Campus API.");
            }
        } catch (\Exception $e) {
            Log::error('Profile Fetch Exception: ' . $e->getMessage());
            return $this->fallbackToLocalAccount("Connection to Campus API timed out.");
        }
    }

    private function fallbackToLocalAccount($errorMessage)
    {
        // Fungsi Penyelamat: Jika API Profil error, cek apakah user sudah pernah tersimpan di DB kita
        if ($this->attemptLocalLogin()) {
            Alert::info('Offline Mode', 'Campus API is busy. Logged in using local data. ✅');
            return $this->redirectBasedOnRole(Auth::user());
        }

        $this->dispatch('swal:alert', [
            'icon' => 'warning',
            'title' => 'API Error',
            'text' => $errorMessage . ' And your account is not yet synced to the local database.',
        ]);
    }

    private function attemptLocalLogin()
    {
        if (
            Auth::attempt(['username' => $this->username, 'password' => $this->password]) ||
            Auth::attempt(['email' => $this->username, 'password' => $this->password])
        ) {
            return true;
        }
        return false;
    }

    protected function redirectBasedOnRole($user)
    {
        if ($user->hasRole('admin')) {
            return redirect()->intended('/dashboard/admin');
        }

        if ($user->hasAnyRole(['mahasiswa', 'dosen', 'pegawai'])) {
            return redirect()->intended('/dashboard');
        }

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.guest');
    }
}
