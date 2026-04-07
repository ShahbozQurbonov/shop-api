<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $products = \App\Models\Product::pluck('id')->all();

        foreach (User::orderBy('id')->get() as $index => $user) {
            $offset = ($index * 3) % max(count($products), 1);
            $selection = array_slice(array_merge($products, $products), $offset, 4);

            if ($selection !== []) {
                $user->favorites()->syncWithoutDetaching($selection);
            }
        }
    }
}
