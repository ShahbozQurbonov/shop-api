<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        Status::create([
            'name' => [
                'uz' => 'Yangi',
                'ru' => 'Новый',
                'tj' => 'Нав'
            ],
            'code' => 'new',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'uz' => 'Tasdiqlandi',
                'ru' => 'Подтверждено',
                'tj' => 'Тасдиқ шуд'
            ],
            'code' => 'confirmed',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'uz' => 'Jarayonda',
                'ru' => 'В процессе',
                'tj' => 'Дар раванд'
            ],
            'code' => 'processing',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'uz' => 'Yetkazilmoqda',
                'ru' => 'Доставляется',
                'tj' => 'Дар роҳ аст'
            ],
            'code' => 'shipping',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'uz' => 'Yetkazildi',
                'ru' => 'Доставлено',
                'tj' => 'Расонида шуд'
            ],
            'code' => 'delivered',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'uz' => 'Yakunlandi',
                'ru' => 'Завершено',
                'tj' => 'Анҷом ёфт'
            ],
            'code' => 'completed',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'uz' => 'Yopildi',
                'ru' => 'Закрыто',
                'tj' => 'Баста шуд'
            ],
            'code' => 'closed',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'uz' => 'Bekor qilindi',
                'ru' => 'Отменено',
                'tj' => 'Бекор карда шуд'
            ],
            'code' => 'canceled',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'uz' => 'Qaytarildi',
                'ru' => 'Возвращено',
                'tj' => 'Баргардонида шуд'
            ],
            'code' => 'refunded',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'uz' => 'To‘lov kutilmoqda',
                'ru' => 'Ожидается оплата',
                'tj' => 'Интизори пардохт'
            ],
            'code' => 'waiting_payment',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'uz' => 'To‘landi',
                'ru' => 'Оплачено',
                'tj' => 'Пардохт шуд'
            ],
            'code' => 'paid',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'uz' => 'To‘lovda xatolik',
                'ru' => 'Ошибка оплаты',
                'tj' => 'Хатогӣ дар пардохт'
            ],
            'code' => 'payment_error',
            'for' => 'order'
        ]);
    }
}