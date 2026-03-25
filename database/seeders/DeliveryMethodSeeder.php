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
                'uz' => 'Tekin',
                'ru' => 'Бесплатно',
                'tj' => 'Ройгон'
            ],
            'estimated_time' => [
                'uz' => '5 kun',
                'ru' => '5 дней',
                'tj' => '5 рӯз'
            ],
            'sum' => 0,
        ]);

        DeliveryMethod::create([
            'name' => [
                'uz' => 'Standart',
                'ru' => 'Стандарт',
                'tj' => 'Стандартӣ'
            ],
            'estimated_time' => [
                'uz' => '3 kun',
                'ru' => '3 дня',
                'tj' => '3 рӯз'
            ],
            'sum' => 40,
        ]);

        DeliveryMethod::create([
            'name' => [
                'uz' => 'Tez',
                'ru' => 'Быстрая',
                'tj' => 'Зуд'
            ],
            'estimated_time' => [
                'uz' => '1 kun',
                'ru' => '1 день',
                'tj' => '1 рӯз'
            ],
            'sum' => 80,
        ]);
    }
}