<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    public function run(): void
    {
        PaymentType::create([
            'name' => [
                'tj' => 'Нақдӣ',
                'ru' => 'Наличные',
                'uz' => 'Naqd',
            ]
        ]);

        PaymentType::create([
            'name' => [
                'tj' => 'Терминал',
                'ru' => 'Терминал',
                'uz' => 'Terminal',
            ]
        ]);

        PaymentType::create([
            'name' => [
                'tj' => 'Корти Миллӣ',
                'ru' => 'Корти Милли',
                'uz' => 'Korti Milli',
            ]
        ]);

        PaymentType::create([
            'name' => [
                'tj' => 'Visa',
                'ru' => 'Visa',
                'uz' => 'Visa',
            ]
        ]);

        PaymentType::create([
            'name' => [
                'tj' => 'Mastercard',
                'ru' => 'Mastercard',
                'uz' => 'Mastercard',
            ]
        ]);
    }
}