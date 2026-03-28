<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use App\Http\Requests\StorePaymentTypeRequest;
use App\Http\Requests\UpdatePaymentTypeRequest;
use Illuminate\Database\Eloquent\Collection;

class PaymentTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
    * @OA\Get(
    *     path="/api/payment-types",
    *     summary="Рӯйхати намудҳои пардохт",
    *     tags={"Payment Types"},
    *
    *     @OA\Response(
    *         response=200,
    *         description="Рӯйхат",
    *         @OA\JsonContent(
    *             @OA\Property(
    *                 property="data",
    *                 type="array",
    *                 @OA\Items(
    *                     type="object",
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(
    *                         property="name",
    *                         type="object",
    *                         example={"tj":"Нақдӣ","ru":"Наличные","uz":"Naqd"}
    *                     )
    *                 )
    *             )
    *         )
    *     )
    * )
    */
    public function index()
    {
        return $this->response(PaymentType::all());
    }

    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/payment-types",
     *     summary="Эҷоди намуди пардохт",
     *     tags={"Payment Types"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(
     *                 property="name",
     *                 type="object",
     *                 example={"tj":"Нақдӣ","ru":"Наличные","uz":"Naqd"}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Сохта шуд")
     * )
     */
    public function store(StorePaymentTypeRequest $request)
    {
        $paymentType = PaymentType::create($request->validated());

        return $this->success('payment type created', $paymentType);
    }

    /**
     * @OA\Get(
     *     path="/api/payment-types/{id}",
     *     summary="Намоиши намуди пардохт",
     *     tags={"Payment Types"},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function show(PaymentType $paymentType)
    {
        return $this->response($paymentType);
    }

    /**
     * @OA\Put(
     *     path="/api/payment-types/{id}",
     *     summary="Навсозии намуди пардохт",
     *     tags={"Payment Types"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="name",
     *                 type="object",
     *                 example={"tj":"Корт","ru":"Карта","uz":"Karta"}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function update(UpdatePaymentTypeRequest $request, PaymentType $paymentType)
    {
        $paymentType->update($request->validated());

        return $this->success('payment type updated', $paymentType);
    }

    /**
     * @OA\Delete(
     *     path="/api/payment-types/{id}",
     *     summary="Нест кардани намуди пардохт",
     *     tags={"Payment Types"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroy(PaymentType $paymentType)
    {
        $paymentType->delete();

        return $this->success('payment type deleted');
    }
}
