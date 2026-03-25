<?php

namespace Database\Seeders;

use App\Enums\SettingType;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $setting = Setting::create([
            'name' => [
                'uz' => 'Til',
                'ru' => 'Язык',
                'tj' => 'Забон'
            ],
            'type' => SettingType::SELECT->value,
        ]);

        $setting->values()->create([
            'name' => [
                'uz' => 'O‘zbekcha',
                'ru' => 'Узбекский',
                'tj' => 'Ӯзбекӣ',
            ]
        ]);

        $setting->values()->create([
            'name' => [
                'uz' => 'Ruscha',
                'ru' => 'Русский',
                'tj' => 'Русӣ',
            ]
        ]);

        $setting->values()->create([
            'name' => [
                'uz' => 'Tojikcha',
                'ru' => 'Таджикский',
                'tj' => 'Тоҷикӣ',
            ]
        ]);

        $setting = Setting::create([
            'name' => [
                'uz' => 'Pul birligi',
                'ru' => 'Валюта',
                'tj' => 'Асъор'
            ],
            'type' => SettingType::SELECT->value,
        ]);

        $setting->values()->create([
            'name' => [
                'uz' => 'Somoni',
                'ru' => 'Сомони',
                'tj' => 'Сомонӣ',
            ]
        ]);

        $setting->values()->create([
            'name' => [
                'uz' => 'Dollar',
                'ru' => 'Доллар',
                'tj' => 'Доллар',
            ]
        ]);

        Setting::create([
            'name' => [
                'uz' => 'Tungi rejim',
                'ru' => 'Тёмный режим',
                'tj' => 'Ҳолати торик'
            ],
            'type' => SettingType::SWITCH->value,
        ]);

        Setting::create([
            'name' => [
                'uz' => 'Bildirishnomalar',
                'ru' => 'Уведомления',
                'tj' => 'Огоҳиномаҳо'
            ],
            'type' => SettingType::SWITCH->value,
        ]);
    }
}