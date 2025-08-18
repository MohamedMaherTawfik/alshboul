<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 2; $i <= 10; $i++) {
            $user = User::create([
                'id' => $i,
                'name' => "User $i",
                'email' => "user$i@example.com",
                'username' => "user$i",
                'phone' => "010000000$i",
                'address' => "Address $i",
                'password' => Hash::make('password'),
                'role' => 'client',
            ]);

            Client::create([
                'id' => $user->id,
                'user_id' => $user->id,
                'name' => $user->name,
                'company_name' => "Company $i",
                'company_national_number' => "COMP$i",
                'national_id' => "12345678$i",
                'nationality' => "Egyptian",
                'phone' => $user->phone,
                'address' => $user->address,
            ]);
        }
    }
}