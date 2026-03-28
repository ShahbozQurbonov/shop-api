<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = app()->environment(['local', 'testing'])
            ? 'passworD1'
            : Str::random(32);

        $users = [
            ['first_name' => 'Admin', 'last_name' => 'Admin', 'email' => 'admin@gmail.com', 'phone' => '+992900000000', 'role' => 'admin'],
            ['first_name' => 'Setora', 'last_name' => 'Qobilova', 'email' => 'setora@gmail.com', 'phone' => '+992901234567', 'role' => 'editor'],
            ['first_name' => 'Sanjar', 'last_name' => 'Eshqobilov', 'email' => 'sanjar@gmail.com', 'phone' => '+992911112233', 'role' => 'shop-manager'],
            ['first_name' => 'Jamila', 'last_name' => 'Toirova', 'email' => 'jamila@gmail.com', 'phone' => '+992935556677', 'role' => 'helpdesk-support'],
            ['first_name' => 'Fazliddin', 'last_name' => 'Qobilov', 'email' => 'fazliddin@gmail.com', 'phone' => '+992987654321', 'role' => 'customer'],
            ['first_name' => 'Muhammad', 'last_name' => 'Safarov', 'email' => 'm.safarov@gmail.com', 'phone' => '+992917001122', 'role' => 'customer'],
            ['first_name' => 'Dilnoza', 'last_name' => 'Karimova', 'email' => 'dilnoza.karimova@gmail.com', 'phone' => '+992918002233', 'role' => 'customer'],
            ['first_name' => 'Farzona', 'last_name' => 'Rahimzoda', 'email' => 'farzona.rahimzoda@gmail.com', 'phone' => '+992919003344', 'role' => 'customer'],
            ['first_name' => 'Behruz', 'last_name' => 'Nazarov', 'email' => 'behruz.nazarov@gmail.com', 'phone' => '+992920004455', 'role' => 'customer'],
            ['first_name' => 'Madina', 'last_name' => 'Saidova', 'email' => 'madina.saidova@gmail.com', 'phone' => '+992921005566', 'role' => 'customer'],
            ['first_name' => 'Abdullo', 'last_name' => 'Yusupov', 'email' => 'abdullo.yusupov@gmail.com', 'phone' => '+992922006677', 'role' => 'customer'],
            ['first_name' => 'Nilufar', 'last_name' => 'Hikmatova', 'email' => 'nilufar.hikmatova@gmail.com', 'phone' => '+992923007788', 'role' => 'customer'],
            ['first_name' => 'Parviz', 'last_name' => 'Rasulov', 'email' => 'parviz.rasulov@gmail.com', 'phone' => '+992924008899', 'role' => 'customer'],
            ['first_name' => 'Zarina', 'last_name' => 'Akramova', 'email' => 'zarina.akramova@gmail.com', 'phone' => '+992925009900', 'role' => 'customer'],
            ['first_name' => 'Kamol', 'last_name' => 'Sharifov', 'email' => 'kamol.sharifov@gmail.com', 'phone' => '+992926101112', 'role' => 'customer'],
        ];

        foreach ($users as $item) {
            $role = $item['role'];
            unset($item['role']);

            $user = User::create([
                ...$item,
                'password' => Hash::make($defaultPassword),
            ]);

            $user->assignRole($role);
        }
    }
}
