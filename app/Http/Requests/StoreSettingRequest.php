<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'name.tj' => 'required|string',
            'name.ru' => 'nullable|string',
            'name.uz' => 'nullable|string',

            'type' => 'required|in:switch,select',

            'values' => 'nullable|array',
            'values.*.name' => 'required|array',
        ];
    }
}
