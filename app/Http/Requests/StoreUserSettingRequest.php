<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserSettingRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'setting_id' => 'required|exists:settings,id',
            'value_id' => 'nullable|exists:values,id',
            'switch' => 'nullable|boolean',
        ];
    }
}
