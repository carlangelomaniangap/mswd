<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'role' => 'admin',
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
        ]);

        User::factory()->create([
            'role' => 'pwd',
            'name' => 'PWD Officer',
            'email' => 'pwd@gmail.com',
        ]);

        User::factory()->create([
            'role' => 'aics',
            'name' => 'Aics Officer',
            'email' => 'aics@gmail.com',
        ]);

        User::factory()->create([
            'role' => 'senior_citizen',
            'name' => 'Senior Citizen Officer',
            'email' => 'senior_citizen@gmail.com',
        ]);

        User::factory()->create([
            'role' => 'solo_parent',
            'name' => 'Solo Parent Officer',
            'email' => 'solo_parent@gmail.com',
        ]);
    }
}
