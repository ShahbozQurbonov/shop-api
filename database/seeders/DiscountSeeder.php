<?php

namespace Database\Seeders;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Product::orderBy('id')->get() as $product) {
            if ($product->id % 2 === 0) {
                $payload = [
                    'percent' => 5 + ($product->id % 11),
                    'sum' => null,
                ];
            } else {
                $payload = [
                    'percent' => null,
                    'sum' => max(50, (int) round($product->price * 0.07)),
                ];
            }

            Discount::create([
                'product_id' => $product->id,
                'name' => 'Тахфифи махсуси ' . $product->getTranslation('name', 'tj'),
                'percent' => $payload['percent'],
                'sum' => $payload['sum'],
                'from' => now()->subDays(5),
                'to' => now()->addDays(20),
            ]);
        }
    }
}
