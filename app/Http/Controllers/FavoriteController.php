<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *     path="/api/favorites",
     *     summary="Рӯйхати дӯстдоштаҳо",
     *     tags={"Favorites"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Рӯйхат",
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="current_page", type="integer", example=1),
     *
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *
     *                     @OA\Property(property="id", type="integer", example=5),
     *                     @OA\Property(property="category_id", type="integer", example=4),
     *
     *                     @OA\Property(
     *                         property="name",
     *                         type="object",
     *                         example={"tj":"consectetur","ru":"reiciendis","uz":"sed doloribus"}
     *                     ),
     *
     *                     @OA\Property(property="price", type="number", example=5792),
     *
     *                     @OA\Property(
     *                         property="description",
     *                         type="object"
     *                     ),
     *
     *                     @OA\Property(property="created_at", type="string", example="2026-03-25T06:40:41.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", example="2026-03-25T06:40:41.000000Z"),
     *
     *                     @OA\Property(
     *                         property="pivot",
     *                         type="object",
     *                         @OA\Property(property="user_id", type="integer", example=1),
     *                         @OA\Property(property="product_id", type="integer", example=5)
     *                     )
     *                 )
     *             ),
     *
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="last_page_url", type="string"),
     *
     *             @OA\Property(
     *                 property="links",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="url", type="string", nullable=true),
     *                     @OA\Property(property="label", type="string"),
     *                     @OA\Property(property="active", type="boolean")
     *                 )
     *             ),
     *
     *             @OA\Property(property="next_page_url", type="string", nullable=true),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="prev_page_url", type="string", nullable=true),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return auth()->user()->favorites()->paginate(20);
    }

    /**
     * @OA\Post(
     *     path="/api/favorites",
     *     summary="Илова ба дӯстдоштаҳо",
     *     tags={"Favorites"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"product_id"},
     *             @OA\Property(property="product_id", type="integer", example=1)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Илова шуд",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Аллакай вуҷуд дорад"
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        if (auth()->user()->hasFavorite($request->product_id)) {
            return $this->error('already in favorites');
        }
        auth()->user()->favorites()->attach($request->product_id);

        return $this->success('added to favorites');
    }

    /**
     * @OA\Delete(
     *     path="/api/favorites/{id}",
     *     summary="Нест кардан аз дӯстдоштаҳо",
     *     tags={"Favorites"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID маҳсулот",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Нест шуд",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Ёфт нашуд"
     *     )
     * )
     */
    public function destroy($product_id): JsonResponse
    {
        if (!auth()->user()->hasFavorite($product_id)) {
            return $this->error('not in favorites');
        }

        auth()->user()->favorites()->detach($product_id);

        return $this->success('removed from favorites');
    }
}
