<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert Admin User
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Use Hash to encrypt the password
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert Karyawan User
        DB::table('users')->insert([
            'name' => 'Karyawan User',
            'email' => 'karyawan@example.com',
            'password' => Hash::make('password'), // Use Hash to encrypt the password
            'role' => 'karyawan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
