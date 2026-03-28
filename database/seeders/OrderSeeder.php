<?php

namespace Database\Seeders;

use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            ['email' => 'fazliddin@gmail.com', 'status' => 'new', 'delivery' => 2, 'payment' => 1, 'products' => [[1, 1], [31, 1]], 'comment' => 'Пеш аз расондан занг занед.'],
            ['email' => 'm.safarov@gmail.com', 'status' => 'confirmed', 'delivery' => 3, 'payment' => 2, 'products' => [[6, 1]], 'comment' => 'Қабул баъд аз соати 18:00.'],
            ['email' => 'dilnoza.karimova@gmail.com', 'status' => 'processing', 'delivery' => 2, 'payment' => 4, 'products' => [[11, 1], [36, 1]], 'comment' => 'Бастабандӣ бодиққат бошад.'],
            ['email' => 'farzona.rahimzoda@gmail.com', 'status' => 'shipping', 'delivery' => 3, 'payment' => 3, 'products' => [[16, 1]], 'comment' => 'Ронанда пешакӣ хабар диҳад.'],
            ['email' => 'behruz.nazarov@gmail.com', 'status' => 'delivered', 'delivery' => 1, 'payment' => 1, 'products' => [[21, 1], [32, 1]], 'comment' => 'Ба идора расонед.'],
            ['email' => 'madina.saidova@gmail.com', 'status' => 'completed', 'delivery' => 2, 'payment' => 4, 'products' => [[26, 1]], 'comment' => 'Фармоиш гирифта шуд.'],
            ['email' => 'abdullo.yusupov@gmail.com', 'status' => 'closed', 'delivery' => 1, 'payment' => 2, 'products' => [[41, 1]], 'comment' => 'Ҳама чиз мувофиқи интизорӣ буд.'],
            ['email' => 'nilufar.hikmatova@gmail.com', 'status' => 'waiting_payment', 'delivery' => 2, 'payment' => 5, 'products' => [[46, 1], [37, 1]], 'comment' => 'Пас аз тасдиқи пардохт фиристед.'],
            ['email' => 'parviz.rasulov@gmail.com', 'status' => 'paid', 'delivery' => 3, 'payment' => 4, 'products' => [[42, 1], [7, 1]], 'comment' => 'Суроға дар профил сабт шудааст.'],
            ['email' => 'zarina.akramova@gmail.com', 'status' => 'canceled', 'delivery' => 2, 'payment' => 1, 'products' => [[47, 1]], 'comment' => 'Мизоҷ фармоишро бекор кард.'],
        ];

        foreach ($orders as $item) {
            $user = User::where('email', $item['email'])->first();
            $status = Status::where('code', $item['status'])->first();
            $delivery = DeliveryMethod::find($item['delivery']);
            $payment = PaymentType::find($item['payment']);
            $address = $user?->addresses()->first();

            if (!$user || !$status || !$delivery || !$payment || !$address) {
                continue;
            }

            [$products, $sum] = $this->buildProducts($item['products']);

            Order::create([
                'user_id' => $user->id,
                'comment' => $item['comment'],
                'delivery_method_id' => $delivery->id,
                'payment_type_id' => $payment->id,
                'sum' => $sum + $delivery->sum,
                'status_id' => $status->id,
                'address' => $address->toArray(),
                'products' => $products,
            ]);
        }
    }

    private function buildProducts(array $items): array
    {
        $products = [];
        $sum = 0;

        foreach ($items as [$productId, $quantity]) {
            $product = Product::with(['category', 'stocks', 'discount', 'photos'])->find($productId);

            if (!$product) {
                continue;
            }

            $stock = $product->stocks->first();
            $discount = $product->getDiscount();
            $basePrice = $product->price;

            if ($discount?->sum) {
                $finalPrice = max(0, $basePrice - $discount->sum);
            } elseif ($discount?->percent) {
                $finalPrice = (int) round($basePrice * ((100 - $discount->percent) / 100));
            } else {
                $finalPrice = $basePrice;
            }

            $linePrice = $finalPrice + ($stock->added_price ?? 0);
            $sum += $linePrice * $quantity;

            $products[] = [
                'id' => $product->id,
                'name' => $product->getTranslations('name'),
                'price' => $product->price,
                'description' => $product->getTranslations('description'),
                'quantity' => $quantity,
                'stock_id' => $stock?->id,
                'added_price' => $stock?->added_price ?? 0,
                'category' => [
                    'id' => $product->category?->id,
                    'name' => $product->category?->getTranslations('name'),
                ],
                'discount' => $discount?->only(['id', 'name', 'percent', 'sum', 'from', 'to']),
                'discounted_price' => $finalPrice,
            ];
        }

        return [$products, $sum];
    }
}
