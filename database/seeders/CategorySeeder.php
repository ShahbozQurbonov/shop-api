<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->categories() as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
    }

    private function categories(): array
    {
        return [
            ['tj' => 'Смартфон', 'ru' => 'Смартфон', 'uz' => 'Smartfon'],
            ['tj' => 'Ноутбук', 'ru' => 'Ноутбук', 'uz' => 'Noutbuk'],
            ['tj' => 'Телевизор', 'ru' => 'Телевизор', 'uz' => 'Televizor'],
            ['tj' => 'Яхдон', 'ru' => 'Холодильник', 'uz' => 'Muzlatgich'],
            ['tj' => 'Мошинаи ҷомашӯй', 'ru' => 'Стиральная машина', 'uz' => 'Kir yuvish mashinasi'],
            ['tj' => 'Кондиционер', 'ru' => 'Кондиционер', 'uz' => 'Konditsioner'],
            ['tj' => 'Гӯшмонак', 'ru' => 'Наушники', 'uz' => 'Quloqchin'],
            ['tj' => 'Соати ҳушманд', 'ru' => 'Смарт-часы', 'uz' => 'Smart soat'],
            ['tj' => 'Камера', 'ru' => 'Камера', 'uz' => 'Kamera'],
            ['tj' => 'Чангкашак', 'ru' => 'Пылесос', 'uz' => 'Changyutgich'],
        ];
    }
}
