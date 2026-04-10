<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat akun Admin
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator Utama',
                'email' => 'admin@furni.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Buat akun Petugas (Staff)
        User::updateOrCreate(
            ['username' => 'petugas'],
            [
                'name' => 'Petugas Operasional',
                'email' => 'petugas@furni.com',
                'password' => Hash::make('admin123'),
                'role' => 'staff',
            ]
        );
    }
}
