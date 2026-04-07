<?php

namespace Database\Seeders;

use App\Models\DeliveryMethod;
use Illuminate\Database\Seeder;

class DeliveryMethodSeeder extends Seeder
{
    public function run(): void
    {
        DeliveryMethod::create([
            'name' => [
                'tj' => 'Ройгон',
                'ru' => 'Бесплатно',
                'uz' => 'Tekin',
            ],
            'estimated_time' => [
                'tj' => '5 рӯз',
                'ru' => '5 дней',
                'uz' => '5 kun',
            ],
            'sum' => 0,
        ]);

        DeliveryMethod::create([
            'name' => [
                'tj' => 'Стандартӣ',
                'ru' => 'Стандарт',
                'uz' => 'Standart',
            ],
            'estimated_time' => [
                'tj' => '3 рӯз',
                'ru' => '3 дня',
                'uz' => '3 kun',
            ],
            'sum' => 40,
        ]);

        DeliveryMethod::create([
            'name' => [
                'tj' => 'Зуд',
                'ru' => 'Быстрая',
                'uz' => 'Tez',
            ],
            'estimated_time' => [
                'tj' => '1 рӯз',
                'ru' => '1 день',
                'uz' => '1 kun',
            ],
            'sum' => 80,
        ]);
    }
}