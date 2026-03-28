<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSettingSeeder extends Seeder
{
    public function run(): void
    {
        $languageSetting = Setting::where('name->tj', 'Забон')->first();
        $currencySetting = Setting::where('name->tj', 'Асъор')->first();
        $darkModeSetting = Setting::where('name->tj', 'Ҳолати торик')->first();
        $notificationsSetting = Setting::where('name->tj', 'Огоҳиномаҳо')->first();

        foreach (User::all() as $index => $user) {
            if ($languageSetting) {
                $languageValue = $languageSetting->values()->get()[$index % 3] ?? null;
                $user->settings()->create([
                    'setting_id' => $languageSetting->id,
                    'value_id' => $languageValue?->id,
                ]);
            }

            if ($currencySetting) {
                $currencyValue = $currencySetting->values()->get()[$index % 2] ?? null;
                $user->settings()->create([
                    'setting_id' => $currencySetting->id,
                    'value_id' => $currencyValue?->id,
                ]);
            }

            if ($darkModeSetting) {
                $user->settings()->create([
                    'setting_id' => $darkModeSetting->id,
                    'switch' => $index % 2 === 0,
                ]);
            }

            if ($notificationsSetting) {
                $user->settings()->create([
                    'setting_id' => $notificationsSetting->id,
                    'switch' => $index % 3 !== 0,
                ]);
            }
        }
    }
}
