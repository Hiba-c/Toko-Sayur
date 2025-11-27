<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::create([
            'nama' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'role' => 1,
            'status' => 1,
            'hp' => '081783647980',
            'password' => Hash::make('P@55word'),
        ]);

        // Admin
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@gmail.com',
            'role' => 0,
            'status' => 1,
            'hp' => '081318880851',
            'password' => Hash::make('P@55word'),
        ]);

        // Member contoh
        User::create([
            'nama' => 'Hiba',
            'email' => 'hiba@gmail.com',
            'role' => 2,
            'status' => 1,
            'hp' => '081234567890',
            'password' => Hash::make('P@55word'),
        ]);
    }
}
