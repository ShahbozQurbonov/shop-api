<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('category:update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'parent_id' => 'nullable|exists:categories,id',
            'name' => 'nullable|array',
            'name.uz' => 'nullable|string',
            'name.ru' => 'nullable|string',
            'name.tj' => 'nullable|string',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
        ];
    }
}
