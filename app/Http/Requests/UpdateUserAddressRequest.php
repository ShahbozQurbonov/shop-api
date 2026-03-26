<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAddressRequest extends FormRequest
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
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'region' => 'nullable|string',
            'district' => 'nullable|string',
            'street' => 'nullable|string',
            'home' => 'nullable|string',
        ];
    }
}
