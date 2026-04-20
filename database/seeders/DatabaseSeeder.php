<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AkademikSeeder::class,
            RoleAndUserSeeder::class,
            ModuleAndPageSeeder::class,
            VocabularyAndTestSeeder::class,
            LeaderboardSeeder::class,
        ]);
    }
}
