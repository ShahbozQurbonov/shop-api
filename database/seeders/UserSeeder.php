<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 🔐 Admin
        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '+992900000000',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('admin');

        // ✍️ Editor
        $user = User::create([
            'first_name' => 'Setora',
            'last_name' => 'Qobilova',
            'email' => 'setora@gmail.com',
            'phone' => '+992901234567',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('editor');

        // 🛒 Shop Manager
        $user = User::create([
            'first_name' => 'Sanjar',
            'last_name' => 'Eshqobilov',
            'email' => 'sanjar@gmail.com',
            'phone' => '+992911112233',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('shop-manager');

        // 🎧 Support
        $user = User::create([
            'first_name' => 'Jamila',
            'last_name' => 'Toirova',
            'email' => 'jamila@gmail.com',
            'phone' => '+992935556677',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('helpdesk-support');

        // 👤 Customer
        $user = User::create([
            'first_name' => 'Fazliddin',
            'last_name' => 'Qobilov',
            'email' => 'fazliddin@gmail.com',
            'phone' => '+992987654321',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('customer');

        // 👥 Fake users
        $users = User::factory()->count(10)->create();

        foreach ($users as $user) {
            $user->assignRole('customer');
        }
    }
}