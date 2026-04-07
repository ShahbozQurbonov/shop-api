<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Http\Resources\StockResource;
use Illuminate\Http\JsonResponse;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        abort_unless(auth()->user()->can('stock:viewAny'), 403);

        return $this->response(StockResource::collection(Stock::latest()->paginate(20)));
    }

    public function store(StoreStockRequest $request): JsonResponse
    {
        $stock = Stock::create($request->validated());

        return $this->success('Сток бо муваффақият сохта шуд', $stock);
    }

    public function show(Stock $stock): JsonResponse
    {
        abort_unless(auth()->user()->can('stock:view'), 403);

        return $this->response(new StockResource($stock));
    }

    public function update(UpdateStockRequest $request, Stock $stock): JsonResponse
    {
        $stock->update($request->validated());

        return $this->success('Сток бо муваффақият навсозӣ шуд', new StockResource($stock));
    }

    public function destroy(Stock $stock): JsonResponse
    {
        abort_unless(auth()->user()->can('stock:delete'), 403);

        $stock->delete();

        return $this->success('Сток бо муваффақият нест карда шуд');
    }
}
