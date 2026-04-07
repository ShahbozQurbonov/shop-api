<?php

namespace Database\Seeders;

use App\Models\PaymentCardType;
use Illuminate\Database\Seeder;

class PaymentCardTypeSeeder extends Seeder
{
    public function run(): void
    {
        PaymentCardType::create([
            'name' => 'Korti Milli',
            'code' => 'korti_milli',
            'icon' => 'korti_milli',
        ]);

        PaymentCardType::create([
            'name' => 'Visa',
            'code' => 'visa',
            'icon' => 'visa',
        ]);

        PaymentCardType::create([
            'name' => 'Mastercard',
            'code' => 'mastercard',
            'icon' => 'mastercard',
        ]);
    }
}