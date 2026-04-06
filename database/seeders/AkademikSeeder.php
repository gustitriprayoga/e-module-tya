<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Data\Fakultas; // Pastiin path modelnya bener ya wak
use App\Models\Data\Prodi;

class AkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Mulai narik data Akademik dari API Kampus... 🚀');

        // 1. Ambil Token Dulu Bosku
        try {
            $loginResponse = Http::withoutVerifying()->post('https://sains.universitaspahlawan.ac.id/api/login', [
                'username' => '1855201011',
                'password' => '1855201011',
            ]);

            $loginData = $loginResponse->json();

            if (!$loginResponse->successful() || ($loginData['isSuccess'] ?? 0) != 200) {
                $this->command->error('Gagal Login API: ' . ($loginData['message'] ?? 'Unknown Error'));
                return; // Stop seeder kalau gagal login
            }

            $token = $loginData['token'];
            $this->command->info('✅ Token secured!');
        } catch (\Exception $e) {
            $this->command->error('Error koneksi pas login API: ' . $e->getMessage());
            return;
        }

        // 2. Sync Data Fakultas
        $this->command->info('⏳ Syncing Fakultas...');
        try {
            $fakultasResponse = Http::withoutVerifying()
                ->withToken($token)
                ->get('https://sains.universitaspahlawan.ac.id/api/fakultas');

            $resFakultasData = $fakultasResponse->json();

            if ($fakultasResponse->successful() && ($resFakultasData['respon'] ?? 'false') == 'true') {
                foreach ($resFakultasData['data'] as $item) {
                    Fakultas::updateOrCreate(
                        ['kode_fakultas' => $item['id_sms']], // id_sms dari API disimpen di kode_fakultas
                        ['nama_fakultas' => $item['nm_lemb']] // nm_lemb disimpen di nama_fakultas
                    );
                }
                $this->command->info('✅ Fakultas synced successfully!');
            } else {
                $this->command->error('Gagal narik data Fakultas.');
            }
        } catch (\Exception $e) {
            $this->command->error('Error narik Fakultas: ' . $e->getMessage());
        }

        // 3. Sync Data Prodi
        $this->command->info('⏳ Syncing Prodi...');
        $mappingJenjang = [
            '86122' => 'S2',
            '46201' => 'S1',
            '61209' => 'S1',
            '60206' => 'S1',
            '13211' => 'S1',
            '74201' => 'S1',
            '14201' => 'S1',
            '15201' => 'S1',
            '13201' => 'S1',
            '94202' => 'S1',
            '88203' => 'S1',
            '86207' => 'S1',
            '86206' => 'S1',
            '85201' => 'S1',
            '84202' => 'S1',
            '61212' => 'S1',
            '54231' => 'S1',
            '26201' => 'S1',
            '55201' => 'S1',
            '22201' => 'S1',
            '15901' => 'Profesi',
            '86906' => 'Profesi',
            '14901' => 'Profesi',
            '15301' => 'D4',
            '15401' => 'D3',
            '14401' => 'D3'
        ];

        try {
            $prodiResponse = Http::withoutVerifying()
                ->withToken($token)
                ->get('https://sains.universitaspahlawan.ac.id/api/prodi');

            $resProdiData = $prodiResponse->json();

            if ($prodiResponse->successful() && ($resProdiData['respon'] ?? 'false') == 'true') {
                foreach ($resProdiData['data'] as $item) {

                    // Cari ID Fakultas di DB lokal berdasarkan id_induk_sms dari API
                    $fakultasLokal = Fakultas::where('kode_fakultas', $item['id_induk_sms'])->first();

                    Prodi::updateOrCreate(
                        ['kode_prodi' => $item['id_sms']], // id_sms prodi jadi kode_prodi
                        [
                            'nama_prodi' => $item['nm_lemb'],
                            'jenjang' => $mappingJenjang[$item['id_sms']] ?? 'Lainnya',
                            // Kalau fakultas ketemu masukin ID-nya, kalau ga kasih null (hati2 error foreign key, mending default ke ID 1 atau diurus dlu datanya)
                            'fakultas_id' => $fakultasLokal ? $fakultasLokal->id : null,
                        ]
                    );
                }
                $this->command->info('✅ Prodi synced successfully!');
            } else {
                $this->command->error('Gagal narik data Prodi.');
            }
        } catch (\Exception $e) {
            $this->command->error('Error narik Prodi: ' . $e->getMessage());
        }

        $this->command->info('🎉 DONE WAK! Semua data master akademik udah nyender dengan manis di database.');
    }
}
