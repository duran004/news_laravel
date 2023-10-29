<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Ad alanı boş bırakılamaz.',
            'name.string' => 'Ad alanı metin tipinde olmalıdır.',
            'name.min' => 'Ad alanı en az 3 karakterden oluşmalıdır.',
            'name.max' => 'Ad alanı en fazla 255 karakterden oluşmalıdır.',
            'email.required' => 'E-posta alanı boş bırakılamaz.',
            'email.email' => 'E-posta alanı e-posta formatında olmalıdır.',
            'email.unique' => 'Bu e-posta adresi daha önce kullanılmış.',
            'password.required' => 'Şifre alanı boş bırakılamaz.',
            'password.string' => 'Şifre alanı metin tipinde olmalıdır.',
            'password.min' => 'Şifre alanı en az 6 karakterden oluşmalıdır.',
            'password.max' => 'Şifre alanı en fazla 255 karakterden oluşmalıdır.'
        ];
    }
}
