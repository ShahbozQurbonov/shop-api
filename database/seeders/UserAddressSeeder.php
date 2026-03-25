<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserAddressSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::find(2);

        if (!$user) {
            return;
        }

        $user->addresses()->create([
            "latitude" => "38.5598",
            "longitude" => "68.7870",
            "region" => "Душанбе",
            "district" => "Шоҳмансур",
            "street" => "кӯчаи Рӯдакӣ",
            "home" => "777",
        ]);

        $user->addresses()->create([
            "latitude" => "38.5733",
            "longitude" => "68.7866",
            "region" => "Душанбе",
            "district" => "Исмоили Сомонӣ",
            "street" => "кӯчаи Сомонӣ",
            "home" => "123",
        ]);
    }
}