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
                'uz' => 'Naqd',
                'ru' => 'Наличные',
                'tj' => 'Нақдӣ'
            ]
        ]);

        PaymentType::create([
            'name' => [
                'uz' => 'Terminal',
                'ru' => 'Терминал',
                'tj' => 'Терминал'
            ]
        ]);

        PaymentType::create([
            'name' => [
                'uz' => 'Korti Milli',
                'ru' => 'Корти Милли',
                'tj' => 'Корти Миллӣ'
            ]
        ]);

        PaymentType::create([
            'name' => [
                'uz' => 'Visa',
                'ru' => 'Visa',
                'tj' => 'Visa'
            ]
        ]);

        PaymentType::create([
            'name' => [
                'uz' => 'Mastercard',
                'ru' => 'Mastercard',
                'tj' => 'Mastercard'
            ]
        ]);
    }
}