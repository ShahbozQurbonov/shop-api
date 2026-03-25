<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => [
                'uz' => 'Stol',
                'ru' => 'Стол',
                'tj' => 'Миз'
            ],
        ]);

        Category::create([
            'name' => [
                'uz' => 'Divan',
                'ru' => 'Диван',
                'tj' => 'Диван'
            ],
        ]);

        $category = Category::create([
            'name' => [
                'uz' => 'Kreslo',
                'ru' => 'Кресло',
                'tj' => 'Курсӣ'
            ],
        ]);

        $category->childCategories()->create([
            'name' => [
                'uz' => 'Ofis',
                'ru' => 'Офис',
                'tj' => 'Идора'
            ],
        ]);

        $childCategory = $category->childCategories()->create([
            'name' => [
                'uz' => 'Geymer',
                'ru' => 'Игровое',
                'tj' => 'Бозӣ'
            ],
        ]);

        $childCategory->childCategories()->create([
            'name' => [
                'uz' => 'RGB',
                'ru' => 'RGB',
                'tj' => 'RGB'
            ],
        ]);

        $childCategory->childCategories()->create([
            'name' => [
                'uz' => 'Ayollar uchun',
                'ru' => 'Женское',
                'tj' => 'Барои занон'
            ],
        ]);

        $childCategory->childCategories()->create([
            'name' => [
                'uz' => 'Qora',
                'ru' => 'Чёрный',
                'tj' => 'Сиёҳ'
            ],
        ]);

        $category->childCategories()->create([
            'name' => [
                'uz' => 'Yumshoq',
                'ru' => 'Мягкое',
                'tj' => 'Нарм'
            ],
        ]);

        Category::create([
            'name' => [
                'uz' => 'Yotoq',
                'ru' => 'Кровать',
                'tj' => 'Кат'
            ],
        ]);

        Category::create([
            'name' => [
                'uz' => 'Stul',
                'ru' => 'Стул',
                'tj' => 'Курсӣ'
            ],
        ]);
    }
}