<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
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

            // هنا نعمل 3 clients لكل يوزر
            for ($j = 1; $j <= 3; $j++) {
                Client::create([
                    // سيب الـ id يجي auto increment عشان ميعملش تعارض
                    'user_id' => $user->id,
                    'name' => $user->name . " - Client $j",
                    'company_name' => "Company {$i}_{$j}",
                    'company_national_number' => "COMP{$i}{$j}",
                    'national_id' => "12345678{$i}{$j}",
                    'nationality' => "Egyptian",
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'added_by' => $user->id
                ]);
            }
        }
    }
}
