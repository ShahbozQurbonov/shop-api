<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductReviewContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
    * @OA\Get(
    *     path="/api/products/{product}/reviews",
    *     summary="Шарҳҳои маҳсулот",
    *     tags={"Product Reviews"},
    *     security={{"bearerAuth":{}}},
    *
    *     @OA\Parameter(
    *         name="product",
    *         in="path",
    *         required=true,
    *         description="ID маҳсулот",
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *
    *     @OA\Response(
    *         response=200,
    *         description="Рӯйхат",
    *         @OA\JsonContent(
    *             type="object",
    *
    *             @OA\Property(property="data", type="object",
    *
    *                 @OA\Property(property="overall_rating", type="number", example=4.5),
    *                 @OA\Property(property="reviews_count", type="integer", example=10),
    *
    *                 @OA\Property(
    *                     property="reviews",
    *                     type="object",
    *
    *                     @OA\Property(
    *                         property="data",
    *                         type="array",
    *                         @OA\Items(
    *                             type="object",
    *                             @OA\Property(property="id", type="integer", example=1),
    *                             @OA\Property(property="rating", type="integer", example=5),
    *                             @OA\Property(property="body", type="string", example="Very good"),
    *
    *                             @OA\Property(
    *                                 property="user",
    *                                 type="object",
    *                                 example={"id":1,"name":"Ali"}
    *                             )
    *                         )
    *                     ),
    *
    *                     @OA\Property(property="links", type="object"),
    *                     @OA\Property(property="meta", type="object")
    *                 )
    *             )
    *         )
    *     )
    * )
    */
    public function index(Product $product): JsonResponse
    {
        $avg = $product->reviews()->avg('rating') ?? 0;

        return $this->response([
            'overall_rating' => round($avg, 1),
            'reviews_count' => $product->reviews()->count(),
            'reviews' => $product->reviews()->with('user')->paginate(10),
        ]);
    }


    /**
    * @OA\Post(
    *     path="/api/products/{product}/reviews",
    *     summary="Илова кардани шарҳ",
    *     tags={"Product Reviews"},
    *     security={{"bearerAuth":{}}},
    *
    *     @OA\Parameter(
    *         name="product",
    *         in="path",
    *         required=true,
    *         description="ID маҳсулот",
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"rating"},
    *             @OA\Property(property="rating", type="integer", example=5),
    *             @OA\Property(property="body", type="string", example="Аъло маҳсулот")
    *         )
    *     ),
    *
    *     @OA\Response(
    *         response=200,
    *         description="Сохта шуд",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="message", type="string", example="review created"),
    *             @OA\Property(property="data", type="object")
    *         )
    *     )
    * )
    */
    public function store(Product $product, StoreReviewRequest $request): JsonResponse
    {
        if ($product->reviews()->where('user_id', auth()->id())->exists()) {
            return $this->error('you already reviewed this product');
        }
        $review = $product->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'body' => $request->body,
        ]);

        return $this->success('review created', $review);
    }
}
