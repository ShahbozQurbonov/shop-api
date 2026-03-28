<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('product:update');
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
        'category_id' => 'nullable|exists:categories,id',

        'name' => 'nullable|array',
        'name.uz' => 'nullable|string|max:255',
        'name.ru' => 'nullable|string|max:255',
        'name.tj' => 'nullable|string|max:255',

        'price' => 'nullable|numeric|min:0',

        'description' => 'nullable|array',
        'description.uz' => 'nullable|string',
        'description.ru' => 'nullable|string',
        'description.tj' => 'nullable|string',
        ];
    }
}
