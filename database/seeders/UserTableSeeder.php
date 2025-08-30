<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'], // Kriteria pencarian
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'phone' => '08123456789',
                'status' => 'admin',
                'password' => Hash::make('superadminabis'),
                'admin_verified' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        $this->command->info('Super Admin user created/updated.');
    }
}
