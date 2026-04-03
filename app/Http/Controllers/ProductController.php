<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Рӯйхати маҳсулотҳо",
     *     tags={"Products"},
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Рӯйхати маҳсулотҳо",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="object"),
     *                     @OA\Property(property="price", type="number", example=5000),
     *                     @OA\Property(property="description", type="object"),
     *                     @OA\Property(property="discounted_price", type="number", example=4500),
     *                     @OA\Property(property="currency", type="string", example="TJS"),
     *                     @OA\Property(property="price_formatted", type="string", example="5 000 TJS")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return ProductResource::collection(Product::cursorPaginate(25));
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Эҷоди маҳсулоти нав",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"category_id","name","price","description"},
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="name", type="object",
     *                 @OA\Property(property="tj", type="string", example="Миз"),
     *                 @OA\Property(property="ru", type="string", example="Стол"),
     *                 @OA\Property(property="uz", type="string", example="Stol"),
     *             ),
     *             @OA\Property(property="price", type="number", example=5000),
     *             @OA\Property(property="description", type="object",
     *                 @OA\Property(property="tj", type="string"),
     *                 @OA\Property(property="ru", type="string"),
     *                 @OA\Property(property="uz", type="string"),
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Маҳсулот бомуваффақият сохта шуд"
     *     )
     * )
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->toArray());

        return $this->success('product created', new ProductResource($product));
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Намоиши як маҳсулот",
     *     tags={"Products"},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID-и маҳсулот",
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Муваффақ",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="object"),
     *             @OA\Property(property="price", type="number", example=5000),
     *             @OA\Property(property="description", type="object"),
     *             @OA\Property(property="discounted_price", type="number", example=4500),
     *             @OA\Property(property="currency", type="string", example="TJS"),
     *             @OA\Property(property="price_formatted", type="string", example="5 000 TJS")
     *         )
     *     )
     * )
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Навсозии маҳсулот",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID-и маҳсулот",
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             required={"category_id","name","price","description"},
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="name", type="object",
     *                 @OA\Property(property="tj", type="string", example="Миз"),
     *                 @OA\Property(property="ru", type="string", example="Стол"),
     *                 @OA\Property(property="uz", type="string", example="Stol"),
     *             ),
     *             @OA\Property(property="price", type="number", example=5000),
     *             @OA\Property(property="description", type="object",
     *                 @OA\Property(property="tj", type="string"),
     *                 @OA\Property(property="ru", type="string"),
     *                 @OA\Property(property="uz", type="string"),
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Маҳсулот бомуваффақият навсозӣ шуд"
     *     )
     * )
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return $this->success('product updated');
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Нест кардани маҳсулот",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID-и маҳсулот",
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Маҳсулот нест карда шуд"
     *     )
     * )
     */
    public function destroy(Product $product)
    {
        Gate::authorize('product:delete');

        Storage::delete($product->photos()->pluck('path')->toArray());
        $product->photos()->delete();
        $product->delete();

        return $this->success('product deleted');
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}/related",
     *     summary="Маҳсулотҳои монанд",
     *     tags={"Products"},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID-и маҳсулот",
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Рӯйхат",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="object"),
     *                 @OA\Property(property="price", type="number", example=5000)
     *             )
     *         )
     *     )
     * )
     */
    public function related(Product $product)
    {
        return $this->response(
            ProductResource::collection(
                Product::query()
                    ->where('category_id', $product->category_id)
                    ->limit(20)
                    ->get())
        );
    }
}
