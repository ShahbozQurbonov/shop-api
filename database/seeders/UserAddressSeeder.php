<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserAddressSeeder extends Seeder
{
    public function run(): void
    {
        $addresses = [
            'fazliddin@gmail.com' => [
                ['latitude' => '40.2826', 'longitude' => '69.6222', 'region' => 'Хуҷанд', 'district' => 'Микроноҳияи 19', 'street' => 'кӯчаи Исмоили Сомонӣ', 'home' => '27'],
                ['latitude' => '40.2894', 'longitude' => '69.6431', 'region' => 'Хуҷанд', 'district' => 'Марказ', 'street' => 'кӯчаи Камоли Хуҷандӣ', 'home' => '14'],
            ],
            'm.safarov@gmail.com' => [
                ['latitude' => '40.2868', 'longitude' => '69.6175', 'region' => 'Хуҷанд', 'district' => 'Микроноҳияи 12', 'street' => 'кӯчаи Гагарин', 'home' => '33'],
            ],
            'dilnoza.karimova@gmail.com' => [
                ['latitude' => '40.2912', 'longitude' => '69.6314', 'region' => 'Хуҷанд', 'district' => 'Маҳаллаи Темурмалик', 'street' => 'кӯчаи Сирдарё', 'home' => '18А'],
            ],
            'farzona.rahimzoda@gmail.com' => [
                ['latitude' => '40.2779', 'longitude' => '69.6297', 'region' => 'Хуҷанд', 'district' => '8-март', 'street' => 'кӯчаи Рифъат Ҳоҷиев', 'home' => '52'],
            ],
            'behruz.nazarov@gmail.com' => [
                ['latitude' => '40.2950', 'longitude' => '69.6462', 'region' => 'Хуҷанд', 'district' => 'Марказ', 'street' => 'кӯчаи Шарқ', 'home' => '9'],
            ],
            'madina.saidova@gmail.com' => [
                ['latitude' => '40.3001', 'longitude' => '69.6203', 'region' => 'Хуҷанд', 'district' => 'Микроноҳияи 13', 'street' => 'кӯчаи Бобоҷон Ғафуров', 'home' => '41'],
            ],
            'abdullo.yusupov@gmail.com' => [
                ['latitude' => '40.2844', 'longitude' => '69.6388', 'region' => 'Хуҷанд', 'district' => 'Панҷшанбе', 'street' => 'кӯчаи Панҷшанбе', 'home' => '65'],
            ],
            'nilufar.hikmatova@gmail.com' => [
                ['latitude' => '40.2873', 'longitude' => '69.6510', 'region' => 'Хуҷанд', 'district' => 'Сайҳун', 'street' => 'кӯчаи Мавлонбеков', 'home' => '22'],
            ],
            'parviz.rasulov@gmail.com' => [
                ['latitude' => '40.2798', 'longitude' => '69.6142', 'region' => 'Хуҷанд', 'district' => 'Микроноҳияи 20', 'street' => 'кӯчаи Дӯстии халқҳо', 'home' => '71'],
            ],
            'zarina.akramova@gmail.com' => [
                ['latitude' => '40.2936', 'longitude' => '69.6265', 'region' => 'Хуҷанд', 'district' => 'Марказ', 'street' => 'кӯчаи Абӯмаҳмуди Хуҷандӣ', 'home' => '16'],
            ],
            'kamol.sharifov@gmail.com' => [
                ['latitude' => '40.2811', 'longitude' => '69.6354', 'region' => 'Хуҷанд', 'district' => 'Чоршанбе', 'street' => 'кӯчаи Шоҳтемур', 'home' => '48'],
            ],
        ];

        foreach ($addresses as $email => $items) {
            $user = User::where('email', $email)->first();

            if (!$user) {
                continue;
            }

            foreach ($items as $address) {
                $user->addresses()->create($address);
            }
        }
    }
}
