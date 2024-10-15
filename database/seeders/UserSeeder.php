<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'username' => 'admin_user',
            'password' => bcrypt('password'),  // You can use bcrypt to hash the password
            'name' => 'Admin',
            'role' => 'admin'
        ]);

        User::create([
            'username' => 'employee_user',
            'password' => bcrypt('password'),
            'name' => 'Employee',
            'role' => 'karyawan'
        ]);
    }
}
