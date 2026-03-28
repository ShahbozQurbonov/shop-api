<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeOrderStatusRequest;
use App\Models\Order;
use App\Models\Status;

class StatusOrderController extends Controller
{
    /**
    * @OA\Post(
    *     path="/api/statuses/{status}/orders",
    *     summary="Тағйири статуси фармоиш",
    *     description="Статуси фармоишро ба статуси интихобшуда иваз мекунад",
    *     tags={"Statuses/Orders"},
    *     security={{"bearerAuth":{}}},
    *
    *     @OA\Parameter(
    *         name="status",
    *         in="path",
    *         description="ID статус",
    *         required=true,
    *         @OA\Schema(type="integer", example=2)
    *     ),
    *
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"order_id"},
    *             @OA\Property(property="order_id", type="integer", example=10)
    *         )
    *     ),
    *
    *     @OA\Response(
    *         response=200,
    *         description="Статус иваз шуд",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="message", type="string", example="status changed")
    *         )
    *     ),
    *
    *     @OA\Response(
    *         response=404,
    *         description="Order ё Status ёфт нашуд"
    *     ),
    *
    *     @OA\Response(
    *         response=403,
    *         description="Иҷозат нест"
    *     )
    * )
    */
    public function store(Status $status, ChangeOrderStatusRequest $request)
    {
        $order = Order::findOrFail($request['order_id']);

        if ($order->status_id == $status->id) {
            return $this->error('status already set');
        }

        $order->update(['status_id' => $status->id]);

        return response(['success' => true, 'message' => 'status changed']);
    }
}
