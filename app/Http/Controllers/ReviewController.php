<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->authorizeResource(Review::class, 'review');
    }

    /**
     * @OA\Get(
     *     path="/api/reviews",
     *     summary="Рӯйхати шарҳҳои корбар",
     *     tags={"Reviews"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Рӯйхати шарҳҳо"
     *     )
     * )
     */
    public function index()
    {
        return $this->response(
            auth()->user()->reviews()->with('product')->paginate(10)
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/reviews",
     *     summary="Эҷоди шарҳ",
     *     tags={"Reviews"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"product_id","rating"},
     *             @OA\Property(property="product_id", type="integer", example=1),
     *             @OA\Property(property="rating", type="integer", example=5),
     *             @OA\Property(property="body", type="string", example="Маҳсулот хеле хуб аст")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Шарҳ сохта шуд"
     *     )
     * )
     */
    public function store(StoreReviewRequest $request)
    {
        $exists = Review::query()
            ->where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return $this->error('you already reviewed this product');
        }

        $review = Review::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'body' => $request->body,
        ]);

        return $this->success('Шарҳ сохта шуд', $review->load('product', 'user'));
    }

    /**
     * @OA\Get(
     *     path="/api/reviews/{id}",
     *     summary="Намоиши шарҳ",
     *     tags={"Reviews"},
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
     *         description="Маълумоти шарҳ"
     *     )
     * )
     */
    public function show(Review $review)
    {
        return $this->response($review->load('product', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/api/reviews/{id}",
     *     summary="Навсозии шарҳ",
     *     tags={"Reviews"},
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
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="rating", type="integer", example=4),
     *             @OA\Property(property="body", type="string", example="Тағйир дода шуд")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Шарҳ навсозӣ шуд"
     *     )
     * )
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $review->update($request->validated());

        return $this->success('Шарҳ навсозӣ шуд', $review->fresh()->load('product', 'user'));
    }

    /**
     * @OA\Delete(
     *     path="/api/reviews/{id}",
     *     summary="Нест кардани шарҳ",
     *     tags={"Reviews"},
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
     *         description="Шарҳ нест карда шуд"
     *     )
     * )
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return $this->success('Шарҳ нест карда шуд');
    }
}
