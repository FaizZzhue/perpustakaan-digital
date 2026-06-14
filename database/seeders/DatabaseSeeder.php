<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'member',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@perpus.com'],
            [
                'name' => 'Admin Perpustakaan',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
    }
}
