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
                'tj' => 'Нав',
                'ru' => 'Новый',
                'uz' => 'Yangi',
            ],
            'code' => 'new',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'tj' => 'Тасдиқ шуд',
                'ru' => 'Подтверждено',
                'uz' => 'Tasdiqlandi',
            ],
            'code' => 'confirmed',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'tj' => 'Дар раванд',
                'ru' => 'В процессе',
                'uz' => 'Jarayonda',
            ],
            'code' => 'processing',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'tj' => 'Дар роҳ аст',
                'ru' => 'Доставляется',
                'uz' => 'Yetkazilmoqda',
            ],
            'code' => 'shipping',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'tj' => 'Расонида шуд',
                'ru' => 'Доставлено',
                'uz' => 'Yetkazildi',
            ],
            'code' => 'delivered',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'tj' => 'Анҷом ёфт',
                'ru' => 'Завершено',
                'uz' => 'Yakunlandi',
            ],
            'code' => 'completed',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'tj' => 'Баста шуд',
                'ru' => 'Закрыто',
                'uz' => 'Yopildi',
            ],
            'code' => 'closed',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'tj' => 'Бекор карда шуд',
                'ru' => 'Отменено',
                'uz' => 'Bekor qilindi',
            ],
            'code' => 'canceled',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'tj' => 'Баргардонида шуд',
                'ru' => 'Возвращено',
                'uz' => 'Qaytarildi',
            ],
            'code' => 'refunded',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'tj' => 'Интизори пардохт',
                'ru' => 'Ожидается оплата',
                'uz' => 'To‘lov kutilmoqda',
            ],
            'code' => 'waiting_payment',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'tj' => 'Пардохт шуд',
                'ru' => 'Оплачено',
                'uz' => 'To‘landi',
            ],
            'code' => 'paid',
            'for' => 'order'
        ]);

        Status::create([
            'name' => [
                'tj' => 'Хатогӣ дар пардохт',
                'ru' => 'Ошибка оплаты',
                'uz' => 'To‘lovda xatolik',
            ],
            'code' => 'payment_error',
            'for' => 'order'
        ]);
    }
}