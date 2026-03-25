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
                    "uz" => "Qizil",
                    "ru" => "Красный",
                    "tj" => "Сурх"
                ]
            ]);

            $attribute->values()->create([
                "name" => [
                    "uz" => "Qora",
                    "ru" => "Чёрный",
                    "tj" => "Сиёҳ"
                ]
            ]);

            $attribute->values()->create([
                "name" => [
                    "uz" => "Jigarrang",
                    "ru" => "Коричневый",
                    "tj" => "Қаҳваранг"
                ]
            ]);
        }

        $attribute = Attribute::find(2);

        if ($attribute) {
            $attribute->values()->create([
                "name" => [
                    "uz" => "MDF",
                    "ru" => "МДФ",
                    "tj" => "MDF"
                ],
            ]);

            $attribute->values()->create([
                "name" => [
                    "uz" => "LDSP",
                    "ru" => "ЛДСП",
                    "tj" => "LDSP"
                ]
            ]);
        }
    }
}