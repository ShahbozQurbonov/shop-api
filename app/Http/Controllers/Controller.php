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
 * ),
 *   @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *     type="http",
 *    scheme="bearer",
 *    bearerFormat="JWT"
 * ),
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

    protected function translateMessage(?string $message): string
    {
        $translations = [
            'Unauthorized' => 'Шумо барои иҷрои ин амал иҷозат надоред',
            'Invalid photoable_type' => 'Намуди объекти акс нодуруст аст',
            'Product not found' => 'Маҳсулот ёфт нашуд',
            'already in favorites' => 'Ин маҳсулот аллакай дар дӯстдоштаҳо ҳаст',
            'not in favorites' => 'Ин маҳсулот дар дӯстдоштаҳо нест',
            'some products not found' => 'Баъзе маҳсулотҳо ёфт нашуданд',
            'some products not found or does not have in inventory' => 'Баъзе маҳсулотҳо ёфт нашуданд ё дар анбор мавҷуд нестанд',
            'you already reviewed this product' => 'Шумо аллакай ба ин маҳсулот шарҳ додаед',
            'setting already exists' => 'Ин танзимот аллакай вуҷуд дорад',
            'status already set' => 'Ин ҳолат аллакай таъин шудааст',
            'persmission already exists' => 'Ин иҷозат аллакай вуҷуд дорад',
            'permission already assigned' => 'Ин иҷозат аллакай ба нақш вобаста шудааст',
            'added to favorites' => 'Маҳсулот ба дӯстдоштаҳо илова шуд',
            'removed from favorites' => 'Маҳсулот аз дӯстдоштаҳо хориҷ карда шуд',
            'order created' => 'Фармоиш бо муваффақият сохта шуд',
            'order updated' => 'Фармоиш бо муваффақият навсозӣ шуд',
            'order deleted' => 'Фармоиш бо муваффақият нест карда шуд',
            'status created' => 'Ҳолат бо муваффақият сохта шуд',
            'status updated' => 'Ҳолат бо муваффақият навсозӣ шуд',
            'status deleted' => 'Ҳолат бо муваффақият нест карда шуд',
            'card added' => 'Корти пардохт бо муваффақият илова шуд',
            'card deleted' => 'Корти пардохт бо муваффақият нест карда шуд',
            'attribute created' => 'Атрибут бо муваффақият сохта шуд',
            'attribute updated' => 'Атрибут бо муваффақият навсозӣ шуд',
            'attribute deleted' => 'Атрибут бо муваффақият нест карда шуд',
            'setting created' => 'Танзимот бо муваффақият сохта шуд',
            'setting updated' => 'Танзимот бо муваффақият навсозӣ шуд',
            'setting deleted' => 'Танзимот бо муваффақият нест карда шуд',
            'payment type created' => 'Намуди пардохт бо муваффақият сохта шуд',
            'payment type updated' => 'Намуди пардохт бо муваффақият навсозӣ шуд',
            'payment type deleted' => 'Намуди пардохт бо муваффақият нест карда шуд',
            'permission created' => 'Иҷозат бо муваффақият сохта шуд',
            'permission assigned to role' => 'Иҷозат бо муваффақият ба нақш вобаста шуд',
            'shipping address created' => 'Нишонии интиқол бо муваффақият сохта шуд',
            'address updated' => 'Нишонӣ бо муваффақият навсозӣ шуд',
            'address deleted' => 'Нишонӣ бо муваффақият нест карда шуд',
            'review created' => 'Шарҳ бо муваффақият сохта шуд',
            'category created' => 'Категория бо муваффақият сохта шуд',
            'category updated' => 'Категория бо муваффақият навсозӣ шуд',
            'discount created' => 'Тахфиф бо муваффақият сохта шуд',
            'discount deleted' => 'Тахфиф бо муваффақият нест карда шуд',
            'success' => 'Амалиёт бо муваффақият анҷом ёфт',
            'value created' => 'Арзиш бо муваффақият сохта шуд',
            'value updated' => 'Арзиш бо муваффақият навсозӣ шуд',
            'value deleted' => 'Арзиш бо муваффақият нест карда шуд',
            'ok' => 'Воридшавӣ бомуваффақият анҷом ёфт',
            'user created' => 'Корбар бо муваффақият сохта шуд',
            'user setting created' => 'Танзимоти корбар бо муваффақият сохта шуд',
            'user setting updated' => 'Танзимоти корбар бо муваффақият навсозӣ шуд',
            'user setting deleted' => 'Танзимоти корбар бо муваффақият нест карда шуд',
            'product created' => 'Маҳсулот бо муваффақият сохта шуд',
            'product updated' => 'Маҳсулот бо муваффақият навсозӣ шуд',
            'product deleted' => 'Маҳсулот бо муваффақият нест карда шуд',
        ];

        return $translations[$message] ?? ($message ?? 'Хатогӣ рух дод');
    }

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
            'message' => $this->translateMessage($message ?? 'Амалиёт бомуваффақият анҷом ёфт'),
            'data' => $data,
        ]);
    }

    public function error(string $message, $data = null, int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status' => 'error',
            'message' => $this->translateMessage($message),
            'data' => $data,
        ], $status);
    }
}
