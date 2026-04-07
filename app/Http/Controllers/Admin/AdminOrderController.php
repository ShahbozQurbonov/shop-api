<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    protected OrderRepository $orderRepository;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('permission:order:viewAny')->only(['index']);
        $this->orderRepository = app(OrderRepository::class);
    }

    /**
    * @OA\Get(
    *     path="/api/admin/orders",
    *     summary="Рӯйхати фармоишҳо (Admin)",
    *     description="Гирифтани ҳамаи фармоишҳо бо филтр ва пагинация",
    *     tags={"Admin/Orders"},
    *     security={{"bearerAuth":{}}},
    *
    *     @OA\Parameter(
    *         name="user_id",
    *         in="query",
    *         description="ID корбар",
    *         required=false,
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *
    *     @OA\Parameter(
    *         name="delivery_method_id",
    *         in="query",
    *         description="ID усули интиқол",
    *         required=false,
    *         @OA\Schema(type="integer", example=2)
    *     ),
    *
    *     @OA\Parameter(
    *         name="payment_type_id",
    *         in="query",
    *         description="ID намуди пардохт",
    *         required=false,
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *
    *     @OA\Parameter(
    *         name="sum_from",
    *         in="query",
    *         description="Маблағи аз",
    *         required=false,
    *         @OA\Schema(type="number", example=100)
    *     ),
    *
    *     @OA\Parameter(
    *         name="sum_to",
    *         in="query",
    *         description="Маблағи то",
    *         required=false,
    *         @OA\Schema(type="number", example=1000)
    *     ),
    *
    *     @OA\Parameter(
    *         name="from",
    *         in="query",
    *         description="Санаи оғоз",
    *         required=false,
    *         @OA\Schema(type="string", format="date", example="2025-01-01")
    *     ),
    *
    *     @OA\Parameter(
    *         name="to",
    *         in="query",
    *         description="Санаи анҷом",
    *         required=false,
    *         @OA\Schema(type="string", format="date", example="2025-01-31")
    *     ),
    *
    *     @OA\Parameter(
    *         name="order_by",
    *         in="query",
    *         description="Сортировка (created_at, sum, id)",
    *         required=false,
    *         @OA\Schema(type="string", example="created_at")
    *     ),
    *
    *     @OA\Parameter(
    *         name="paginate",
    *         in="query",
    *         description="Шумора дар як саҳифа",
    *         required=false,
    *         @OA\Schema(type="integer", example=20)
    *     ),
    *
    *     @OA\Response(
    *         response=200,
    *         description="Рӯйхати фармоишҳо",
    *         @OA\JsonContent(
    *             @OA\Property(
    *                 property="data",
    *                 type="array",
    *                 @OA\Items(
    *                     type="object",
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(property="comment", type="string", example="Тезтар оваред"),
    *                     @OA\Property(property="sum", type="number", example=250.5),
    *
    *                     @OA\Property(
    *                         property="user",
    *                         type="object",
    *                         example={"id":1,"name":"Ali"}
    *                     ),
    *
    *                     @OA\Property(
    *                         property="status",
    *                         type="object",
    *                         example={"id":1,"name":"closed"}
    *                     ),
    *
    *                     @OA\Property(
    *                         property="products",
    *                         type="array",
    *                         @OA\Items(type="object")
    *                     ),
    *
    *                     @OA\Property(
    *                         property="address",
    *                         type="object",
    *                         example={"city":"Dushanbe","street":"Rudaki"}
    *                     ),
    *
    *                     @OA\Property(
    *                         property="payment_type",
    *                         type="object",
    *                         example={"id":1,"name":"cash"}
    *                     ),
    *
    *                     @OA\Property(
    *                         property="delivery_method",
    *                         type="object",
    *                         example={"id":1,"name":"courier"}
    *                     )
    *                 )
    *             ),
    *             @OA\Property(property="links", type="object"),
    *             @OA\Property(property="meta", type="object")
    *         )
    *     ),
    *
    *     @OA\Response(
    *         response=403,
    *         description="Иҷозат нест"
    *     )
    * )
    */
    public function index(Request $request)
    {
        $orders = $this->orderRepository->getAll($request);

        return OrderResource::collection($orders);
    }
}
