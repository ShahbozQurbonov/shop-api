<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreValueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('value:create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|array', // translatable
            'name.*' => 'string',

            'valueable_id' => 'required|integer',
            'valueable_type' => 'required|string', 
            // masalan: App\Models\Attribute yoki App\Models\Setting
        ];
    }
}
