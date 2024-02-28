<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCategoryRequest extends FormRequest
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
        return [];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Kategori id zorunludur.',
            'id.integer' => 'Kategori id tam sayı olmalıdır.',
            'id.exists' => 'Kategori bulunamadı.'
        ];
    }
}
