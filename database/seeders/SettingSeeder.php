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
                'tj' => 'Забон',
                'ru' => 'Язык',
                'uz' => 'Til',
            ],
            'type' => SettingType::SELECT->value,
        ]);

        $setting->values()->create([
            'name' => [
                'tj' => 'Ӯзбекӣ',
                'ru' => 'Узбекский',
                'uz' => 'O‘zbekcha',
            ]
        ]);

        $setting->values()->create([
            'name' => [
                'tj' => 'Русӣ',
                'ru' => 'Русский',
                'uz' => 'Ruscha',
            ]
        ]);

        $setting->values()->create([
            'name' => [
                'tj' => 'Тоҷикӣ',
                'ru' => 'Таджикский',
                'uz' => 'Tojikcha',
            ]
        ]);

        $setting = Setting::create([
            'name' => [
                'tj' => 'Асъор',
                'ru' => 'Валюта',
                'uz' => 'Pul birligi',
            ],
            'type' => SettingType::SELECT->value,
        ]);

        $setting->values()->create([
            'name' => [
                'tj' => 'Сомонӣ',
                'ru' => 'Сомони',
                'uz' => 'Somoni',
            ]
        ]);

        $setting->values()->create([
            'name' => [
                'tj' => 'Доллар',
                'ru' => 'Доллар',
                'uz' => 'Dollar',
            ]
        ]);

        Setting::create([
            'name' => [
                'tj' => 'Ҳолати торик',
                'ru' => 'Тёмный режим',
                'uz' => 'Tungi rejim',
            ],
            'type' => SettingType::SWITCH->value,
        ]);

        Setting::create([
            'name' => [
                'tj' => 'Огоҳиномаҳо',
                'ru' => 'Уведомления',
                'uz' => 'Bildirishnomalar',
            ],
            'type' => SettingType::SWITCH->value,
        ]);
    }
}