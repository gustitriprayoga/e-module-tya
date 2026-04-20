<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Roles
        $roles = ['admin', 'dosen', 'mahasiswa', 'panitia', 'umum', 'admin-prodi'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // 2. Buat User Super Admin (Peneliti)
        // $admin = User::firstOrCreate(
        //     ['nim_nip' => '2288203021'], // NIM Mutiara
        //     [
        //         'name' => 'Mutiara Sophia Ningsih',
        //         'email' => 'mutiara@universitaspahlawan.ac.id',
        //         'password' => Hash::make('password123'),
        //     ]
        // );
        // $admin->assignRole('admin');

        // // 3. Buat User Dosen
        // $dosen = User::firstOrCreate(
        //     ['nim_nip' => '096542140'], // NIP Dr. Putri Asilestari
        //     [
        //         'name' => 'Dr. Putri Asilestari, M.Pd.',
        //         'email' => 'putri.asilestari@universitaspahlawan.ac.id',
        //         'password' => Hash::make('password123'),
        //     ]
        // );
        // $dosen->assignRole('dosen');

        // // 4. Buat User Mahasiswa Sampel (Untuk Leaderboard)
        // $student1 = User::firstOrCreate(
        //     ['nim_nip' => '1855201011'],
        //     [
        //         'name' => 'Dr. Gusti Tri',
        //         'email' => 'gusti@universitaspahlawan.ac.id',
        //         'password' => Hash::make('password123'),
        //     ]
        // );
        // $student1->assignRole('mahasiswa');

        // $student2 = User::firstOrCreate(
        //     ['nim_nip' => '1855201012'],
        //     [
        //         'name' => 'Indriyani S.',
        //         'email' => 'indriyani@universitaspahlawan.ac.id',
        //         'password' => Hash::make('password123'),
        //     ]
        // );
        // $student2->assignRole('mahasiswa');
    }
}
