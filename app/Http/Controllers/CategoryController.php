<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Database\Eloquent\Collection;
use OpenApi\Annotations as OA;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','show']);
    }

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Рӯйхати категорияҳоро гирифтан",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Муваффак")
     * )
     */
    public function index()
    {
        return $this->response(
            CategoryResource::collection(
                Category::query()
                    ->whereNull('parent_id')
                    ->with([
                        'childCategories.childCategories',
                    ])
                    ->withCount('products')
                    ->orderBy('id')
                    ->get()
            )
        );
    }


/**
 * @OA\Post(
 *     path="/api/categories",
 *     summary="Эҷоди категория",
 *     tags={"Categories"},
 *     security={{"bearerAuth":{}}},
 * 
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="parent_id", type="integer", example=1),
 *             @OA\Property(property="name", type="object",
 *                 @OA\Property(property="tj", type="string", example="Миз"),
 *                 @OA\Property(property="ru", type="string", example="Стол"),
 *                 @OA\Property(property="uz", type="string", example="Stol"),
 *             ),
 *             @OA\Property(property="icon", type="string", example="icon.png"),
 *             @OA\Property(property="order", type="integer", example=1)
 *         )
 *     ),
 * 
 *     @OA\Response(
 *         response=200,
 *         description="Категория сохта шуд"
 *     )
 * )
 */
public function store(StoreCategoryRequest $request)
{
    $category = Category::create($request->validated());

    return $this->success('category created', new CategoryResource($category));
}

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Намоиши категория",
     *     tags={"Categories"},
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
     *     )
     * )
     */
    public function show(Category $category)
    {
        return $this->response(
            new CategoryResource(
                $category->load(['childCategories.childCategories'])->loadCount('products')
            )
        );
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     summary="Навсозии категория",
     *     tags={"Categories"},
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
     *             @OA\Property(property="parent_id", type="integer"),
     *             @OA\Property(property="name", type="object",
     *                 @OA\Property(property="tj", type="string"),
     *                 @OA\Property(property="ru", type="string"),
     *                 @OA\Property(property="uz", type="string"),
     *             ),
     *             @OA\Property(property="icon", type="string"),
     *             @OA\Property(property="order", type="integer")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Категория навсозӣ шуд"
     *     )
     * )
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return $this->success('category updated', new CategoryResource($category));
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="Нест кардани категория",
     *     tags={"Categories"},
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
     *         description="Категория нест карда шуд"
     *     )
     * )
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->success('Категория нест карда шуд');
    }
}
