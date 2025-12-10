<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // ← WAJIB DITAMBAHKAN

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'password' => Hash::make('password'), // ✔ aman
            'role' => 'staf',
            'status' => 'aktif',
        ]);
    }
}