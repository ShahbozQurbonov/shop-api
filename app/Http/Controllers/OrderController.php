<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Product;
use App\Models\Stock;
use App\Models\UserAddress;
use App\Repositories\OrderRepository;
use App\Repositories\StockRepository;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService   $orderService,
        protected ProductService $productService,
    )
    {
        $this->middleware('auth:api');
        $this->authorizeResource(Order::class, 'order');
    }

    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="Рӯйхати фармоишҳои корбар",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="status_id",
     *         in="query",
     *         required=false,
     *         description="Филтр аз рӯи ҳолат",
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Рӯйхати фармоишҳо",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="sum", type="number"),
     *                     @OA\Property(property="comment", type="string"),
     * 
     *                     @OA\Property(property="status", type="object"),
     * 
     *                     @OA\Property(
     *                         property="products",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="id", type="integer"),
     *                             @OA\Property(property="name", type="object"),
     *                             @OA\Property(property="price", type="number"),
     *                             @OA\Property(property="quantity", type="integer")
     *                         )
     *                     ),
     * 
     *                     @OA\Property(property="address", type="object")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        if (request()->has('status_id')) {
            return $this->response(OrderResource::collection(auth()->user()->orders()->where('status_id', request('status_id'))->paginate(10)));
        }

        return $this->response(OrderResource::collection(auth()->user()->orders()->paginate(10)));
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Эҷоди фармоиш",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"delivery_method_id","payment_type_id","products"},
     *             
     *             @OA\Property(property="delivery_method_id", type="integer", example=1),
     *             @OA\Property(property="payment_type_id", type="integer", example=1),
     *             @OA\Property(property="address_id", type="integer", example=1),
     * 
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="product_id", type="integer", example=1),
     *                     @OA\Property(property="quantity", type="integer", example=2),
     *                     @OA\Property(property="stock_id", type="integer", example=1)
     *                 )
     *             ),
     * 
     *             @OA\Property(property="comment", type="string", example="Илтимос зуд расонед")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Фармоиш сохта шуд"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Баъзе маҳсулот дастрас нестанд"
     *     )
     * )
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        // o'zgaruvchilani belgilash
        list($sum, $products, $notFoundProducts, $address, $deliveryMethod) = $this->defineVariables($request);

        // omborda product bor yo'qligiga tekshirish
        list($sum, $products, $notFoundProducts) = $this->productService->checkForStock($request['products'], $sum, $products, $notFoundProducts);

        // bor bo'lsa buyurtma yaratish
        if ($notFoundProducts === [] && $products !== [] && $sum !== 0) {
            $order = $this->orderService->saveOrder($deliveryMethod, $sum, $request, $address, $products);
            return $this->success('order created', $order);
        }

        return $this->error('some products not found or does not have in inventory', ['not_found_products' => $notFoundProducts]);
    }

    /**
     * @OA\Get(
     *     path="/api/orders/{id}",
     *     summary="Намоиши як фармоиш",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID-и фармоиш",
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Маълумоти фармоиш",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="sum", type="number"),
     *             @OA\Property(property="comment", type="string"),
     * 
     *             @OA\Property(property="user", type="object"),
     *             @OA\Property(property="status", type="object"),
     * 
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="object"),
     *                     @OA\Property(property="price", type="number"),
     *                     @OA\Property(property="quantity", type="integer")
     *                 )
     *             ),
     * 
     *             @OA\Property(property="address", type="object"),
     *             @OA\Property(property="payment_type", type="object"),
     *             @OA\Property(property="delivery_method", type="object")
     *         )
     *     )
     * )
     */
    public function show(Order $order): JsonResponse
    {
        return $this->response(new OrderResource($order));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/api/orders/{id}",
     *     summary="Навсозии фармоиш",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID-и фармоиш",
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="delivery_method_id", type="integer", example=1),
     *             @OA\Property(property="payment_type_id", type="integer", example=1),
     *             @OA\Property(property="address_id", type="integer", example=1),
     *             @OA\Property(property="status_id", type="integer", example=2),
     *             @OA\Property(property="comment", type="string", example="Тағйир дода шуд"),
     * 
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="product_id", type="integer", example=1),
     *                     @OA\Property(property="quantity", type="integer", example=2),
     *                     @OA\Property(property="stock_id", type="integer", example=1)
     *                 )
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Фармоиш бомуваффақият навсозӣ шуд"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Баъзе маҳсулот дастрас нестанд"
     *     )
     * )
     */
    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        $data = $request->validated();
    
        // 🔄 oddiy fieldlar
        $order->update([
            'delivery_method_id' => $data['delivery_method_id'] ?? $order->delivery_method_id,
            'payment_type_id'    => $data['payment_type_id'] ?? $order->payment_type_id,
            'status_id'          => $data['status_id'] ?? $order->status_id,
            'comment'            => $data['comment'] ?? $order->comment,
        ]);
    
        // 📦 products JSON bilan ishlash
        if (!empty($data['products'])) {
    
            $sum = 0;
            $products = [];
            $notFoundProducts = [];
    
            list($sum, $products, $notFoundProducts) =
                $this->productService->checkForStock(
                    $data['products'],
                    $sum,
                    $products,
                    $notFoundProducts
                );
    
            if (!empty($notFoundProducts)) {
                return $this->error('some products not found', [
                    'not_found_products' => $notFoundProducts
                ]);
            }
    
            // ✅ JSON sifatida saqlaymiz
            $order->update([
                'products' => $products,
                'sum' => $sum
            ]);
        }
    
        // 📍 address ham JSON
        if (!empty($data['address_id'])) {
            $address = UserAddress::find($data['address_id']);
    
            $order->update([
                'address' => $address
            ]);
        }
    
        return $this->success('order updated', new OrderResource($order->fresh()));
    }

    /**
     * @OA\Delete(
     *     path="/api/orders/{id}",
     *     summary="Нест кардани фармоиш",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID-и фармоиш",
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Фармоиш нест карда шуд"
     *     )
     * )
     */
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        return $this->success('order deleted');
    }


    public function defineVariables(StoreOrderRequest $request): array
    {
        $sum = 0;
        $products = [];
        $notFoundProducts = [];
        $address = UserAddress::find($request->address_id);
        $deliveryMethod = DeliveryMethod::findOrFail($request->delivery_method_id);
        return array($sum, $products, $notFoundProducts, $address, $deliveryMethod);
    }
}
