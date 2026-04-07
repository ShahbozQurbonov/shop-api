<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserPaymentCardsRequest extends FormRequest
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
            "name" => "required|string|max:255",
            "number" => "required|digits_between:12,19",
            "exp_date" => "required|string",
            "holder_name" => "required|string|max:255",
            "payment_card_type_id" => "required|exists:payment_card_types,id",
        ];
    }
}
