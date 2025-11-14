<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin1',
            'username' => 'admin1',
            'email' => 'admin1',
            'password' => bcrypt('admin'),
            'address' => 'Mansoura elteera street 6 building',
            'role' => 'superadmin',
            'phone' => '123456789',
            'active' => true,
            'date' => time(),
        ]);

        User::create([
            'name' => 'admin2',
            'username' => 'admin2',
            'email' => 'admin2',
            'password' => bcrypt('admin'),
            'address' => 'Mansoura elteera street 6 building',
            'role' => 'admin',
            'phone' => '123456789',
            'active' => true,
            'date' => time(),
        ]);

        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin',
            'password' => bcrypt('admin'),
            'address' => 'Mansoura elteera street 6 building',
            'role' => 'doctor',
            'phone' => '123456789',
            'active' => true,
            'date' => time(),
        ]);




    }
}