<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Module;
use App\Models\Block;
use App\Models\ReadingHistory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LeaderboardSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil Modul & Block untuk relasi
        $module = Module::first();
        $block = Block::where('type', 'reading_text')->first() ?? Block::first();

        if (!$module || !$block) {
            $this->command->warn('Data Module atau Block tidak ditemukan. Jalankan ModuleAndPageSeeder dulu!');
            return;
        }

        // 2. Daftar nama Juara untuk simulasi Podium
        $topPerformers = [
            ['name' => 'Dr. Gusti Tri', 'wpm' => 312, 'nim' => '1855201901'], // NIM unik
            ['name' => 'Mutiara Sophia', 'wpm' => 285, 'nim' => '1855201902'],
            ['name' => 'Indriyani S.', 'wpm' => 260, 'nim' => '1855201903'],
        ];

        // 3. Bersihkan data riwayat lama (agar tidak penuh saat testing)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ReadingHistory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 4. Input Top 3 (Podium)
        foreach ($topPerformers as $index => $data) {
            $user = User::updateOrCreate(
                ['username' => 'user_top_' . ($index + 1)],
                [
                    'name' => $data['name'],
                    'nim_nip' => $data['nim'],
                    'email' => 'top' . ($index + 1) . '@litflow.com',
                    'password' => Hash::make('password'),
                ]
            );

            ReadingHistory::create([
                'user_id' => $user->id,
                'module_id' => $module->id,
                'block_id' => $block->id,
                'duration_seconds' => rand(100, 150),
                'wpm_result' => $data['wpm'],
                'accuracy_score' => rand(85, 100),
            ]);
        }

        // 5. Input 17 Siswa lainnya (Peringkat 4 - 20)
        // Gunakan prefix NIM '99' agar tidak mungkin bentrok dengan NIM asli (18...)
        for ($i = 4; $i <= 20; $i++) {
            $user = User::updateOrCreate(
                ['username' => 'student_random_' . $i],
                [
                    'name' => 'Student Athlete ' . $i,
                    'nim_nip' => '9955201' . str_pad($i, 3, '0', STR_PAD_LEFT), // Diganti jadi awalan 99
                    'email' => 'student' . $i . '@litflow.com',
                    'password' => Hash::make('password'),
                ]
            );

            ReadingHistory::create([
                'user_id' => $user->id,
                'module_id' => $module->id,
                'block_id' => $block->id,
                'duration_seconds' => rand(160, 300),
                'wpm_result' => rand(100, 240),
                'accuracy_score' => rand(70, 95),
            ]);
        }

        $this->command->info('✅ LeaderboardSeeder Fixed: NIM Duplikat teratasi!');
    }
}
