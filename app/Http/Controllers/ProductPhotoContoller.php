<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductPhotoRequest;
use App\Models\Photo;
use App\Models\Product;
use App\Services\FileService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ProductPhotoContoller extends Controller
{
    public function __construct(
        protected FileService $fileService,
    )
    {
        $this->middleware('auth:api')->except(['index']);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{product}/photos",
     *     summary="Аксҳои маҳсулот",
     *     tags={"Product Photos"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Рӯйхати аксҳо"
     *     )
     * )
     */
    public function index(Product $product)
    {
        return $this->response($product->photos);
    }

    /**
    * @OA\Post(
    *     path="/api/products/{product}/photos",
    *     summary="Илова кардани акс ба маҳсулот",
    *     tags={"Product Photos"},
    *     security={{"bearerAuth":{}}},
    * 
    *     @OA\Parameter(
    *         name="product",
    *         in="path",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    * 
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="photos[]",
    *                     type="array",
    *                     @OA\Items(type="string", format="binary")
    *                 )
    *             )
    *         )
    *     ),
    * 
    *     @OA\Response(
    *         response=200,
    *         description="Аксҳо илова шуданд"
    *     )
    * )
    */
    public function store(StoreProductPhotoRequest $request, Product $product)
    {
        $this->fileService->saveProductPhotos($request, $product);

        return $this->success('Аксҳо илова шуданд');
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{product}/photos/{photo}",
     *     summary="Нест кардани акси маҳсулот",
     *     tags={"Product Photos"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\Parameter(
     *         name="photo",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Акс нест карда шуд"
     *     )
     * )
     */
    public function destroy(Product $product, Photo $photo)
    {
        Gate::authorize('product:delete');
    
        if ($photo->photoable_id !== $product->id) {
            abort(403);
        }
    
        Storage::disk('public')->delete($photo->path);
        $photo->delete();
    
        return $this->success('Акс нест карда шуд');
    }

}
