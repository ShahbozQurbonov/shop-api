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
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Рӯйхати категорияҳоро гирифтан",
     *     tags={"Categories"},
     *     @OA\Response(response=200, description="Муаффак")
     * )
     */
    public function index()
    {
        return $this->response(Category::all());
    }


    /**
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Категорияи нав эҷод кардан",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=201, description="Эҷод шуд")
     * )
     */
    public function store(StoreCategoryRequest $request)
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Категорияи мушаххасро нишон додан",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Муаффак")
     * )
     */
    public function show(Category $category)
    {
        return $this->response(new CategoryResource($category));
    }


    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    public function destroy(Category $category)
    {
        //
    }
}
