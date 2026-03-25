<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends FormRequest
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
            'name' => 'nullable|array',
            'name.tj' => 'nullable|string',
            'name.ru' => 'nullable|string',
            'name.uz' => 'nullable|string',
            'for' => 'nullable|string',
            'code' => 'nullable|string|unique:statuses,code,' . $this->route('id')
        ];
    }
}
