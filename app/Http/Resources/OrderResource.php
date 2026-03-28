<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'sum' => $this->sum,
            'sum_formatted' => number_format($this->sum, 0, '.', ' ') . ' TJS',
            'currency' => 'TJS',
            'user' => $this->user,
            'status' => $this->status,
            'products' => $this->products,
            'address' => $this->address,
            'payment_type' => $this->paymentType,
            'delivery_method' => $this->deliveryMethod,
        ];
    }
}
