<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('category:create');
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
            'parent_id' => 'nullable|exists:categories,id',

            'name' => 'required|array',
            'name.uz' => 'required|string|max:255',
            'name.ru' => 'required|string|max:255',
            'name.tj' => 'required|string|max:255',

            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
        ];
    }
}
