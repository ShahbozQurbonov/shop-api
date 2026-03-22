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
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Order::class, 'order');
    }


    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="Рӯйхати фармоишҳоро гирифтан",
     *     tags={"Orders"},
     *     @OA\Response(response=200, description="Муаффак")
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
     *     summary="Фармоиш эҷод кардан",
     *     tags={"Orders"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=201, description="Эҷод шуд")
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
     *     path="/api/orders/{order}",
     *     summary="Фармоишро нишон додан",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Муаффак")
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
     *     path="/api/orders/{order}",
     *     summary="Фармоишро навсозӣ кардан",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=200, description="Навсозӣ шуд")
     * )
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * @OA\Delete(
     *     path="/api/orders/{order}",
     *     summary="Фармоишро нест кардан",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Нест шуд")
     * )
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return 1;
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
