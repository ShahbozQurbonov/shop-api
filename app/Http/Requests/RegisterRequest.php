<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',

            'email' => 'required|string|email:rfc,dns|max:255|unique:users,email',

            'phone' => [
                'required',
                'string',
                'regex:/^\+?992[0-9]{9}$/',
                'unique:users,phone'
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],

            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ];
    }
    public function messages(): array
    {
         return [
            'first_name.required' => 'Ном ҳатмӣ мебошад',
            'first_name.string' => 'Ном бояд матн бошад',
            'first_name.max' => 'Ном набояд аз 255 аломат зиёд бошад',

            'last_name.required' => 'Насаб ҳатмӣ мебошад',
            'last_name.string' => 'Насаб бояд матн бошад',
            'last_name.max' => 'Насаб набояд аз 255 аломат зиёд бошад',

            'email.required' => 'Email ҳатмӣ мебошад',
            'email.email' => 'Формати email нодуруст аст',
            'email.unique' => 'Ин email аллакай истифода шудааст',
            'email.max' => 'Email хеле дароз аст',

            'phone.required' => 'Рақами телефон ҳатмӣ мебошад',
            'phone.string' => 'Рақами телефон бояд матн бошад',
            'phone.regex' => 'Формати рақами телефон нодуруст аст. Он бояд бо 992 оғоз шавад ва аз 9 рақами дигар иборат бошад (мисол: +992924002010)',
            'phone.unique' => 'Ин рақам аллакай истифода шудааст',

            'password.required' => 'Парол ҳатмӣ мебошад',
            'password.string' => 'Парол бояд матн бошад',
            'password.min' => 'Парол бояд ҳадди ақал 8 аломат дошта бошад',
            'password.confirmed' => 'Паролҳо мувофиқат намекунанд',
            'password.regex' => 'Парол бояд ҳарфи калон ва рақам дошта бошад',

            'photo.image' => 'Файл бояд тасвир (image) бошад',
            'photo.mimes' => 'Формати файл бояд jpg, jpeg ё png бошад',
            'photo.max' => 'Андозаи файл набояд аз 1MB зиёд бошад',
        ];
    }
}
