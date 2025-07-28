<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'username' => 'admin',
            'email' => 'admin',
            'password' => bcrypt('admin'),
            'address'=>'Mansoura elteera street 6 building',
            'role' => 'superadmin',
            'phone' => '123456789',
            'active' => true,
            'date' => time(),
        ]);
    }
}
