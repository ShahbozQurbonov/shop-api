<?php

namespace App\Http\Controllers;

use App\Models\PaymentCardType;
use App\Http\Requests\StorePaymentCardTypeRequest;
use App\Http\Requests\UpdatePaymentCardTypeRequest;

class PaymentCardTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function index()
    {
        return $this->response(PaymentCardType::all());
    }

    public function store(StorePaymentCardTypeRequest $request)
    {
        $paymentCardType = PaymentCardType::create($request->validated());

        return $this->success('Намуди корти пардохт бо муваффақият сохта шуд', $paymentCardType);
    }

    public function show(PaymentCardType $paymentCardType)
    {
        return $this->response($paymentCardType);
    }

    public function update(UpdatePaymentCardTypeRequest $request, PaymentCardType $paymentCardType)
    {
        $paymentCardType->update($request->validated());

        return $this->success('Намуди корти пардохт бо муваффақият навсозӣ шуд', $paymentCardType);
    }

    public function destroy(PaymentCardType $paymentCardType)
    {
        abort_unless(
            auth()->user()->hasRole('admin') || auth()->user()->hasRole('shop-manager'),
            403
        );

        $paymentCardType->delete();

        return $this->success('Намуди корти пардохт бо муваффақият нест карда шуд');
    }
}
