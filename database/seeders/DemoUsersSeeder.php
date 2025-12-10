<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemoUsersSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
        [
            'username' => 'admin',
            'name' => 'Admin',
            'password' => Hash::make('Password123'),
            'role' => 'admin',
            'status' => 'aktif',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'username' => 'staf',
            'name' => 'Staf',
            'password' => Hash::make('Password123'),
            'role' => 'staf',
            'status' => 'aktif',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'username' => 'pimpinan',
            'name' => 'Pimpinan',
            'password' => Hash::make('Password123'),
            'role' => 'pimpinan',
            'status' => 'aktif',
            'created_at' => $now,
            'updated_at' => $now,
        ],
    ], ['username'], ['name', 'password', 'role', 'status', 'updated_at']);

    }
}