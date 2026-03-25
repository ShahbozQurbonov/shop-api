<?php

namespace App\Http\Controllers;

use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\LazyCollection;

class StatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
    * @OA\Get(
    *     path="/api/admin/stats/orders-count",
    *     summary="Шумораи фармоишҳо",
    *     description="Ин endpoint шумораи фармоишҳои пӯшидашударо дар давраи интихобшуда бармегардонад",
    *     tags={"Statistics"},
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         name="from",
    *         in="query",
    *         description="Санаи оғоз (формат: YYYY-MM-DD)",
    *         required=false,
    *         @OA\Schema(type="string", format="date")
    *     ),
    *     @OA\Parameter(
    *         name="to",
    *         in="query",
    *         description="Санаи анҷом (формат: YYYY-MM-DD)",
    *         required=false,
    *         @OA\Schema(type="string", format="date")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Шумораи фармоишҳо",
    *         @OA\JsonContent(
    *             @OA\Property(property="data", type="integer", example=120)
    *         )
    *     )
    * )
    */
    public function ordersCount(Request $request)
    {
        $from = Carbon::now()->subMonth();
        $to = Carbon::now();

        if ($request->has(['from', 'to'])) {
            $from = $request->from;
            $to = $request->to;
        }

        return $this->response(
            Order::query()
                ->whereBetween('created_at', [$from, Carbon::parse($to)->endOfDay()])
                ->whereRelation('status', 'code', 'closed')
                ->count()
        );
    }

    /**
    * @OA\Get(
    *     path="/api/admin/stats/orders-sales-sum",
    *     summary="Ҷамъбасти фурӯш",
    *     description="Ин endpoint маблағи умумии фармоишҳои пӯшидашударо бармегардонад",
    *     tags={"Statistics"},
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         name="from",
    *         in="query",
    *         description="Санаи оғоз",
    *         required=false,
    *         @OA\Schema(type="string", format="date")
    *     ),
    *     @OA\Parameter(
    *         name="to",
    *         in="query",
    *         description="Санаи анҷом",
    *         required=false,
    *         @OA\Schema(type="string", format="date")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Маблағи умумӣ",
    *         @OA\JsonContent(
    *             @OA\Property(property="data", type="number", example=5600.50)
    *         )
    *     )
    * )
    */
    public function ordersSalesSum(Request $request)
    {
        $from = Carbon::now()->subMonth();
        $to = Carbon::now();

        if ($request->has(['from', 'to'])) {
            $from = $request->from;
            $to = $request->to;
        }

        return $this->response(
            Order::query()
                ->whereBetween('created_at', [$from, Carbon::parse($to)->endOfDay()])
                ->whereRelation('status', 'code', 'closed')
                ->sum('sum')
        );
    }

    /**
    * @OA\Get(
    *     path="/api/admin/stats/delivery-methods-ratio",
    *     summary="Тақсимоти усулҳои интиқол",
    *     description="Ин endpoint фоиз ва шумораи фармоишҳоро аз рӯи усули интиқол бармегардонад",
    *     tags={"Statistics"},
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         name="from",
    *         in="query",
    *         description="Санаи оғоз",
    *         required=false,
    *         @OA\Schema(type="string", format="date")
    *     ),
    *     @OA\Parameter(
    *         name="to",
    *         in="query",
    *         description="Санаи анҷом",
    *         required=false,
    *         @OA\Schema(type="string", format="date")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Маълумот дар бораи усулҳои интиқол",
    *         @OA\JsonContent(
    *             @OA\Property(
    *                 property="data",
    *                 type="array",
    *                 @OA\Items(
    *                     @OA\Property(property="name", type="object", example={"tj":"Курьер","ru":"Курьер"}),
    *                     @OA\Property(property="percentage", type="number", example=45.5),
    *                     @OA\Property(property="amount", type="integer", example=50)
    *                 )
    *             )
    *         )
    *     )
    * )
    */
    public function deliveryMethodsRatio(Request $request)
    {
        $from = Carbon::now()->subMonth();
        $to = Carbon::now();

        if ($request->has(['from', 'to'])) {
            $from = $request->from;
            $to = $request->to;
        }

        $response = [];

        $allOrders = Order::query()
            ->whereBetween('created_at', [$from, Carbon::parse($to)->endOfDay()])
            ->whereRelation('status', 'code', 'closed')
            ->count();

        foreach (DeliveryMethod::all() as $deliveryMethod) {
            $deliveryMethodOrders = $deliveryMethod->orders()
                ->whereBetween('created_at', [$from, Carbon::parse($to)->endOfDay()])
                ->whereRelation('status', 'code', 'closed')
                ->count();

            $percentage = $allOrders > 0
                ? round($deliveryMethodOrders * 100 / $allOrders, 1)
                : 0;

            $response[] = [
                'name' => $deliveryMethod->getTranslations('name'),
                'percentage' => $percentage,
                'amount' => $deliveryMethodOrders,
            ];
        }

        return $this->response($response);
    }

    /**
    * @OA\Get(
    *     path="/api/admin/stats/orders-count-by-days",
    *     summary="Шумораи фармоишҳо аз рӯи рӯз",
    *     description="Ин endpoint шумораи фармоишҳоро барои ҳар рӯз дар давраи интихобшуда бармегардонад",
    *     tags={"Statistics"},
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         name="from",
    *         in="query",
    *         description="Санаи оғоз",
    *         required=false,
    *         @OA\Schema(type="string", format="date")
    *     ),
    *     @OA\Parameter(
    *         name="to",
    *         in="query",
    *         description="Санаи анҷом",
    *         required=false,
    *         @OA\Schema(type="string", format="date")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Рӯйхати рӯзҳо бо шумораи фармоишҳо",
    *         @OA\JsonContent(
    *             @OA\Property(
    *                 property="data",
    *                 type="array",
    *                 @OA\Items(
    *                     @OA\Property(property="date", type="string", example="2025-01-01"),
    *                     @OA\Property(property="orders_count", type="integer", example=15)
    *                 )
    *             )
    *         )
    *     )
    * )
    */
    public function ordersCountByDays(Request $request)
    {
        $from = Carbon::now()->subMonth();
        $to = Carbon::now();

        if ($request->has(['from', 'to'])) {
            $from = $request->from;
            $to = $request->to;
        }

        $days = CarbonPeriod::create($from, $to);
        $response = new Collection();

        LazyCollection::make($days->toArray())->each(function ($day) use ($from, $to, $response) {

            $count = Order::query()
                ->whereBetween('created_at', [$day->startOfDay(), $day->endOfDay()])
                ->whereRelation('status', 'code', 'closed')
                ->count();

            $response[] = [
                'date' => $day->format('Y-m-d'),
                'orders_count' => $count,
            ];
        });

        return $this->response($response);
    }
}
