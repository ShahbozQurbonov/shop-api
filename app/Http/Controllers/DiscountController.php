<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

     /**
     * @OA\Get(
     *     path="/api/discounts",
     *     summary="Рӯйхати тахфифҳо",
     *     tags={"Discounts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Муваффақ",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="product_id", type="integer", example=10),
     *                 @OA\Property(property="name", type="string", example="New Year Sale"),
     *                 @OA\Property(property="percent", type="number", example=10),
     *                 @OA\Property(property="sum", type="number", example=10),
     *                 @OA\Property(property="from", type="string", format="date", example="2026-01-01"),
     *                 @OA\Property(property="to", type="string", format="date", example="2026-01-10")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return $this->response(Discount::with('product')->latest()->get());
    }

    /**
     * @OA\Post(
     *     path="/api/discounts",
     *     summary="Эҷоди тахфиф",
     *     tags={"Discounts"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"product_id"},
     *             @OA\Property(property="product_id", type="integer", example=10),
     *             @OA\Property(property="name", type="string", example="Winter Sale"),
     *             @OA\Property(property="percent", type="number", example=15),
     *             @OA\Property(property="sum", type="number", example=5),
     *             @OA\Property(property="from", type="string", format="date", example="2026-01-01"),
     *             @OA\Property(property="to", type="string", format="date", example="2026-01-10")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Тахфиф сохта шуд"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Аллакай тахфиф барои ин маҳсулот вуҷуд дорад"
     *     )
     * )
     */
    public function store(StoreDiscountRequest $request)
    {
        if (Discount::query()->where('product_id', $request->product_id)->exists()){
            return $this->error('Аллакай тахфиф барои ин маҳсулот вуҷуд дорад');
        }

        $discount = Discount::create($request->validated());

        return $this->success('discount created', $discount->load('product'));
    }

     /**
     * @OA\Get(
     *     path="/api/discounts/{id}",
     *     summary="Намоиши як тахфиф",
     *     tags={"Discounts"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Муваффақ"
     *     ),
     *     @OA\Response(response=404, description="Ёфт нашуд")
     * )
     */
    public function show(Discount $discount)
    {
        $discount->load('product');

        return $this->success('success', $discount);
    }

     /**
     * @OA\Put(
     *     path="/api/discounts/{id}",
     *     summary="Навсозии тахфиф",
     *     tags={"Discounts"},
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
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="percent", type="number"),
     *             @OA\Property(property="sum", type="number"),
     *             @OA\Property(property="from", type="string", format="date"),
     *             @OA\Property(property="to", type="string", format="date")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Навсозӣ шуд"
     *     )
     * )
     */
    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        $discount->update($request->validated());

        return $this->success('Навсозӣ шуд', $discount->fresh()->load('product'));
    }

     /**
     * @OA\Delete(
     *     path="/api/discounts/{id}",
     *     summary="Нест кардани тахфиф",
     *     tags={"Discounts"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Тахфиф нест карда шуд"
     *     )
     * )
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return $this->success('discount deleted');
    }
}
