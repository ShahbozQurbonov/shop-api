<?php

namespace Database\Seeders;

use App\Models\PaymentCardType;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserPaymentCardsSeeder extends Seeder
{
    public function run(): void
    {
        $cards = [
            'fazliddin@gmail.com' => [
                ['name' => 'Корти асосӣ', 'number' => '8600123412341111', 'exp_date' => '12/27', 'holder_name' => 'FAZLIDDIN QOBILOV', 'type' => 'korti_milli'],
            ],
            'm.safarov@gmail.com' => [
                ['name' => 'Visa корӣ', 'number' => '4111111111111111', 'exp_date' => '09/28', 'holder_name' => 'MUHAMMAD SAFAROV', 'type' => 'visa'],
            ],
            'dilnoza.karimova@gmail.com' => [
                ['name' => 'Mastercard шахсӣ', 'number' => '5555555555554444', 'exp_date' => '03/29', 'holder_name' => 'DILNOZA KARIMOVA', 'type' => 'mastercard'],
            ],
            'madina.saidova@gmail.com' => [
                ['name' => 'Корти маош', 'number' => '8600987612345678', 'exp_date' => '08/27', 'holder_name' => 'MADINA SAIDOVA', 'type' => 'korti_milli'],
            ],
        ];

        foreach ($cards as $email => $items) {
            $user = User::where('email', $email)->first();

            if (!$user) {
                continue;
            }

            foreach ($items as $card) {
                $type = PaymentCardType::where('code', $card['type'])->first();

                if (!$type) {
                    continue;
                }

                $user->paymentCards()->create([
                    'payment_card_type_id' => $type->id,
                    'name' => encrypt($card['name']),
                    'number' => encrypt($card['number']),
                    'last_four_numbers' => encrypt(substr($card['number'], -4)),
                    'exp_date' => encrypt($card['exp_date']),
                    'holder_name' => encrypt($card['holder_name']),
                ]);
            }
        }
    }
}
