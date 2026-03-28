<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('delivery-method:update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|array',
            'name.tj' => 'nullable|string|max:255',
            'name.ru' => 'nullable|string|max:255',
            'name.uz' => 'nullable|string|max:255',
            'estimated_time' => 'nullable|array',
            'estimated_time.tj' => 'nullable|string|max:255',
            'estimated_time.ru' => 'nullable|string|max:255',
            'estimated_time.uz' => 'nullable|string|max:255',
            'sum' => 'nullable|integer|min:0',
        ];
    }
}
