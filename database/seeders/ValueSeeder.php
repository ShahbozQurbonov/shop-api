<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class ValueSeeder extends Seeder
{
    public function run(): void
    {
        $attribute = Attribute::find(1);

        if ($attribute) {
            $attribute->values()->create([
                "name" => [
                    "tj" => "Сурх",
                    "ru" => "Красный",
                    "uz" => "Qizil",
                ]
            ]);

            $attribute->values()->create([
                "name" => [
                    "tj" => "Сиёҳ",
                    "ru" => "Чёрный",
                    "uz" => "Qora",
                ]
            ]);

            $attribute->values()->create([
                "name" => [
                    "tj" => "Қаҳваранг",
                    "ru" => "Коричневый",
                    "uz" => "Jigarrang",
                ]
            ]);
        }

        $attribute = Attribute::find(2);

        if ($attribute) {
            $attribute->values()->create([
                "name" => [
                    "tj" => "MDF",
                    "ru" => "МДФ",
                    "uz" => "MDF",
                ],
            ]);

            $attribute->values()->create([
                "name" => [
                    "tj" => "LDSP",
                    "ru" => "ЛДСП",
                    "uz" => "LDSP",
                ]
            ]);
        }
    }
}