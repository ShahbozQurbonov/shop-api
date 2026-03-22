<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\returnArgument;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index','show']);
    }

    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Рӯйхати маҳсулотҳоро гирифтан",
     *     tags={"Products"},
     *     @OA\Response(response=200, description="Муаффак")
     * )
     */
    public function index()
    {
        return ProductResource::collection(Product::cursorPaginate(25));
    }


    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Маҳсулот эҷод кардан",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=201, description="Эҷод шуд")
     * )
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->toArray());

        return $this->success('product created', new ProductResource($product));
    }


    /**
     * @OA\Get(
     *     path="/api/products/{product}",
     *     summary="Маҳсулотро нишон додан",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Муаффак")
     * )
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }


    /**
     * @OA\Put(
     *     path="/api/products/{product}",
     *     summary="Маҳсулотро навсозӣ кардан",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="product",
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
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{product}",
     *     summary="Маҳсулотро нест кардан",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Нест шуд")
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
     *     path="/api/products/{product}/related",
     *     summary="Маҳсулотҳои алоқамандро гирифтан",
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Муаффак")
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
