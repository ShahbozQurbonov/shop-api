<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories/{category}/products",
     *     summary="Гирифтани маҳсулотҳо аз рӯи категория",
     *     description="Рӯйхати саҳифабандишудаи маҳсулотҳо, ки ба як категория тааллуқ доранд, бо истифода аз cursor pagination",
     *     tags={"CategoryProduct"},
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         required=true,
     *         description="ID-и категория",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Маҳсулотҳо бомуваффақият гирифта шуданд",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Категория ёфт нашуд"
     *     )
     * )
     */
    public function index(Category $category)
    {
        return $category->products()->cursorPaginate(25);
    }
}
