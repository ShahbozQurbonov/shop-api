<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('email', '!=', 'admin@gmail.com')->take(10)->get()->values();
        $products = Product::orderBy('id')->take(30)->get()->values();
        $templates = [
            'Сифаташ хуб аст ва барои ин нарх арзанда мебошад.',
            'Дар истифода қулай баромад ва аз харид қаноатмандам.',
            'Бастабандӣ хуб буд, маҳсулот бе мушкил омад.',
            'Барои истифодаи ҳаррӯза мувофиқ аст ва хуб кор мекунад.',
            'Тарҳ ва кори маҳсулот ба ман маъқул шуд.',
        ];

        $reviews = [];

        foreach ($products as $index => $product) {
            $user = $users[$index % $users->count()] ?? null;

            if (!$user) {
                continue;
            }

            $reviews[] = [
                'email' => $user->email,
                'product_id' => $product->id,
                'rating' => 4 + ($index % 2),
                'body' => $templates[$index % count($templates)],
            ];
        }

        foreach ($reviews as $item) {
            $user = User::where('email', $item['email'])->first();

            if (!$user || !Product::find($item['product_id'])) {
                continue;
            }

            Review::create([
                'user_id' => $user->id,
                'product_id' => $item['product_id'],
                'rating' => $item['rating'],
                'body' => $item['body'],
            ]);
        }
    }
}
