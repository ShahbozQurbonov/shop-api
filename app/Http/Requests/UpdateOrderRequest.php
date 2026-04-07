<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('order:update');
        // return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'delivery_method_id' => 'nullable|integer|exists:delivery_methods,id',
            'payment_type_id'    => 'nullable|integer|exists:payment_types,id',
            'address_id'         => 'nullable|integer|exists:user_addresses,id',
            'status_id'          => 'nullable|integer|exists:statuses,id',
            'comment'            => 'nullable|string|max:500',

            'products' => 'nullable|array',
            'products.*.product_id' => 'required_with:products|integer|exists:products,id',
            'products.*.quantity'   => 'required_with:products|integer|min:1',
            'products.*.stock_id'   => 'nullable|integer|exists:stocks,id',
        ];
    }
}
