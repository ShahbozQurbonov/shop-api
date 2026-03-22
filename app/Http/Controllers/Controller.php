<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API барои системаи тиҷоратии электронӣ",
 *     version="1.0.0",
 *     description="Санади API барои ҳама контроллерҳо"
 * )
 * @OA\Tag(name="Users", description="Корбарон")
 * @OA\Tag(name="Auth", description="Аутентификация ва иҷозат")
 * @OA\Tag(name="Roles", description="Ролҳо")
 * @OA\Tag(name="Permissions", description="Иҷозатҳо")
 * @OA\Tag(name="Photos", description="Аксҳо")
 * @OA\Tag(name="Orders", description="Фармоишҳо")
 * @OA\Tag(name="Reviews", description="Шарҳҳо")
 * @OA\Tag(name="Statuses", description="Ҳолатҳо")
 * @OA\Tag(name="Products", description="Маҳсулотҳо")
 * @OA\Tag(name="Settings", description="Танзимотҳо")
 * @OA\Tag(name="Discounts", description="Тахфифҳо")
 * @OA\Tag(name="Favorites", description="Дӯстдоштаҳо")
 * @OA\Tag(name="Categories", description="Категорияҳо")
 * @OA\Tag(name="User Photos", description="Аксҳои корбар") 
 * @OA\Tag(name="User Settings", description="Танзимоти корбар")
 * @OA\Tag(name="Payment Types", description="Намудҳои пардохт")
 * @OA\Tag(name="User Addresses", description="Суроғаҳои корбар")
 * @OA\Tag(name="Product Photos", description="Аксҳои маҳсулот")
 * @OA\Tag(name="Product Reviews", description="Шарҳҳои маҳсулот")
 * @OA\Tag(name="Delivery Methods", description="Усулҳои интиқол")
 * @OA\Tag(name="Payment Card Types", description="Намудҳои кортҳои пардохт")
 * @OA\Tag(name="User Payment Cards", description="Кортҳои пардохти корбар")
 * @OA\Tag(name="Attributes", description="Атрибутҳо")
 * @OA\Tag(name="Values", description="Арзишҳо")
 * @OA\Tag(name="Stocks", description="Стокҳо")
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function response($data): JsonResponse
    {
        return response()->json([
            'data' => $data,
        ]);
    }

    public function success(string $message = null, $data = null): JsonResponse
    {
        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => $message ?? 'operation successfull',
            'data' => $data,
        ]);
    }

    public function error(string $message, $data = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status' => 'error',
            'message' => $message ?? 'error occured',
            'data' => $data,
        ], 400);
    }
}
