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

        $apiUrl = env('KAMPUS_API_URL');
        $ssoSuccess = false;
        $loginData = null;

        // 1. COBA LOGIN VIA SSO KAMPUS (Dibungkus try-catch mandiri agar jika API mati, Local Auth tetap jalan)
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
            Log::error('SSO API Error: ' . $e->getMessage());
            // Biarkan jatuh ke Local Auth
        }

        // JIKA SSO BERHASIL
        if ($ssoSuccess) {
            return $this->handleSSOLogin($loginData, $apiUrl);
        }

        // 2. JIKA SSO GAGAL / API MATI, COBA LOGIN LOKAL (Admin / User yang sudah tersimpan)
        if (
            Auth::attempt(['username' => $this->username, 'password' => $this->password]) ||
            Auth::attempt(['email' => $this->username, 'password' => $this->password])
        ) {
            Alert::success('Success', 'Welcome back to LitFlow! 🎉');
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
        $token = $loginData['token'];

        try {
            // Ambil Detail Profil Mahasiswa/Dosen
            $detailRes = Http::withoutVerifying()
                ->withToken($token)->timeout(10)
                ->get("{$apiUrl}/{$originalRole}", [
                    'username' => $this->username
                ]);

            $detailData = $detailRes->json('data');

            if (!$detailRes->successful() || empty($detailData)) {
                $this->dispatch('swal:alert', [
                    'icon' => 'error',
                    'title' => 'Profile Error',
                    'text' => "Failed to retrieve your profile data from Campus API.",
                ]);
                return;
            }

            DB::transaction(function () use ($loginData, $detailData, $originalRole, $token) {
                // Update atau buat User di DB Lokal
                $user = User::updateOrCreate(
                    ['username' => $this->username],
                    [
                        'name'     => $detailData['nama'] ?? $this->username,
                        'email'    => $loginData['email'] ?? $this->username . '@universitaspahlawan.ac.id',
                        'password' => Hash::make($this->password),
                    ]
                );

                // Inisialisasi Tabel Research Analytic
                ResearchAnalytic::firstOrCreate(['user_id' => $user->id]);

                // Assign Role via Spatie
                if (!Role::where('name', $originalRole)->exists()) Role::create(['name' => $originalRole]);
                if (!Role::where('name', 'admin')->exists()) Role::create(['name' => 'admin']);

                if (!$user->hasRole($originalRole)) {
                    $user->assignRole($originalRole);
                }

                // Bypass Admin untuk NIM Tertentu (Peneliti)
                if ($this->username == '1855201011' && !$user->hasRole('admin')) {
                    $user->assignRole('admin');
                }

                session(['api_token' => $token]);
                Auth::login($user);
            });

            Alert::success('Login Success', 'Welcome to LitFlow! 🎉');
            return $this->redirectBasedOnRole(Auth::user());
        } catch (\Exception $e) {
            Log::error('Profile Fetch Error: ' . $e->getMessage());
            $this->dispatch('swal:alert', [
                'icon' => 'warning',
                'title' => 'Connection Error',
                'text' => 'Failed to connect to Campus API. Please try again.',
            ]);
        }
    }

    protected function redirectBasedOnRole($user)
    {
        if ($user->hasRole('admin')) {
            return redirect()->intended('/dashboard/admin');
        }

        if ($user->hasAnyRole(['mahasiswa', 'dosen'])) {
            return redirect()->intended('/dashboard');
        }

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.guest');
    }
}
