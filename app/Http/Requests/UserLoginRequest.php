<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:255'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'E-posta alanı boş bırakılamaz.',
            'email.email' => 'E-posta alanı e-posta formatında olmalıdır.',
            'password.required' => 'Şifre alanı boş bırakılamaz.',
            'password.string' => 'Şifre alanı metin tipinde olmalıdır.',
            'password.min' => 'Şifre alanı en az 6 karakterden oluşmalıdır.',
            'password.max' => 'Şifre alanı en fazla 255 karakterden oluşmalıdır.'
        ];
    }
}
