<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class ValueSeeder extends Seeder
{
    public function run(): void
    {
        $color = Attribute::find(1);
        $variant = Attribute::find(2);
        $size = Attribute::find(3);

        if ($color) {
            foreach ([
                ['tj' => 'Сиёҳ', 'ru' => 'Чёрный', 'uz' => 'Qora'],
                ['tj' => 'Сафед', 'ru' => 'Белый', 'uz' => 'Oq'],
                ['tj' => 'Кабуд', 'ru' => 'Синий', 'uz' => 'Ko‘k'],
                ['tj' => 'Нуқраӣ', 'ru' => 'Серебристый', 'uz' => 'Kumush'],
                ['tj' => 'Хокистарӣ', 'ru' => 'Серый', 'uz' => 'Kulrang'],
                ['tj' => 'Сабз', 'ru' => 'Зелёный', 'uz' => 'Yashil'],
            ] as $value) {
                $color->values()->create(['name' => $value]);
            }
        }

        if ($variant) {
            foreach ([
                ['tj' => 'Standard', 'ru' => 'Standard', 'uz' => 'Standard'],
                ['tj' => 'Plus', 'ru' => 'Plus', 'uz' => 'Plus'],
                ['tj' => 'Pro', 'ru' => 'Pro', 'uz' => 'Pro'],
                ['tj' => 'Max', 'ru' => 'Max', 'uz' => 'Max'],
                ['tj' => 'Inverter', 'ru' => 'Inverter', 'uz' => 'Inverter'],
                ['tj' => 'Premium', 'ru' => 'Premium', 'uz' => 'Premium'],
            ] as $value) {
                $variant->values()->create(['name' => $value]);
            }
        }

        if ($size) {
            foreach ([
                ['tj' => '42 дюйм', 'ru' => '42 дюйма', 'uz' => '42 dyuym'],
                ['tj' => '55 дюйм', 'ru' => '55 дюймов', 'uz' => '55 dyuym'],
                ['tj' => '65 дюйм', 'ru' => '65 дюймов', 'uz' => '65 dyuym'],
                ['tj' => '1.5 тонна', 'ru' => '1.5 тонны', 'uz' => '1.5 tonna'],
                ['tj' => '2 тонна', 'ru' => '2 тонны', 'uz' => '2 tonna'],
            ] as $value) {
                $size->values()->create(['name' => $value]);
            }
        }
    }
}
