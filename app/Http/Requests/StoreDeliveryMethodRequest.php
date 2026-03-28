<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeliveryMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('delivery-method:create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|array',
            'name.tj' => 'required|string|max:255',
            'name.ru' => 'required|string|max:255',
            'name.uz' => 'required|string|max:255',
            'estimated_time' => 'required|array',
            'estimated_time.tj' => 'required|string|max:255',
            'estimated_time.ru' => 'required|string|max:255',
            'estimated_time.uz' => 'required|string|max:255',
            'sum' => 'required|integer|min:0',
        ];
    }
}
