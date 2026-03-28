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
                'tj' => 'Миз',
                'ru' => 'Стол',
                'uz' => 'Stol',
            ],
        ]);

        Category::create([
            'name' => [
                'tj' => 'Диван',
                'ru' => 'Диван',
                'uz' => 'Divan',
            ],
        ]);

        $category = Category::create([
            'name' => [
                'tj' => 'Курсӣ',
                'ru' => 'Кресло',
                'uz' => 'Kreslo',
            ],
        ]);

        $category->childCategories()->create([
            'name' => [
                'tj' => 'Идора',
                'ru' => 'Офис',
                'uz' => 'Ofis',
            ],
        ]);

        $childCategory = $category->childCategories()->create([
            'name' => [
                'tj' => 'Бозӣ',
                'ru' => 'Игровое',
                'uz' => 'Geymer',
            ],
        ]);

        $childCategory->childCategories()->create([
            'name' => [
                'tj' => 'RGB',
                'ru' => 'RGB',
                'uz' => 'RGB',
            ],
        ]);

        $childCategory->childCategories()->create([
            'name' => [
                'tj' => 'Барои занон',
                'ru' => 'Женское',
                'uz' => 'Ayollar uchun',
            ],
        ]);

        $childCategory->childCategories()->create([
            'name' => [
                'tj' => 'Сиёҳ',
                'ru' => 'Чёрный',
                'uz' => 'Qora',
            ],
        ]);

        $category->childCategories()->create([
            'name' => [
                'tj' => 'Нарм',
                'ru' => 'Мягкое',
                'uz' => 'Yumshoq',
            ],
        ]);

        Category::create([
            'name' => [
                'tj' => 'Кат',
                'ru' => 'Кровать',
                'uz' => 'Yotoq',
            ],
        ]);

        Category::create([
            'name' => [
                'tj' => 'Курсӣ',
                'ru' => 'Стул',
                'uz' => 'Stul',
            ],
        ]);
    }
}