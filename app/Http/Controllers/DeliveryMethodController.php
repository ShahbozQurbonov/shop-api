<?php

namespace App\Http\Controllers;

use App\Models\DeliveryMethod;
use App\Http\Requests\StoreDeliveryMethodRequest;
use App\Http\Requests\UpdateDeliveryMethodRequest;
use Illuminate\Http\JsonResponse;

class DeliveryMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function index(): JsonResponse
    {
        return $this->response(DeliveryMethod::all());
    }

    public function store(StoreDeliveryMethodRequest $request)
    {
        $deliveryMethod = DeliveryMethod::create($request->validated());

        return $this->success('Усули интиқол бо муваффақият сохта шуд', $deliveryMethod);
    }

    public function show(DeliveryMethod $deliveryMethod)
    {
        return $this->response($deliveryMethod);
    }

    public function update(UpdateDeliveryMethodRequest $request, DeliveryMethod $deliveryMethod)
    {
        $deliveryMethod->update($request->validated());

        return $this->success('Усули интиқол бо муваффақият навсозӣ шуд', $deliveryMethod);
    }

    public function destroy(DeliveryMethod $deliveryMethod)
    {
        abort_unless(auth()->user()->can('delivery-method:delete'), 403);

        $deliveryMethod->delete();

        return $this->success('Усули интиқол бо муваффақият нест карда шуд');
    }
}
