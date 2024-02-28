<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' => 'nullable|string|max:90',
            'description' => 'nullable|string',
            'title' => 'nullable|string',
            'slug' => 'nullable|string',
            'image_id' => 'nullable|integer|exists:images,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Kategori id zorunludur.',
            'id.integer' => 'Kategori id tam sayı olmalıdır.',
            'id.exists' => 'Kategori bulunamadı.',
            'name.string' => 'Kategori adı metin tipinde olmalıdır.',
            'name.max' => 'Kategori adı en fazla 90 karakter olmalıdır.',
            'description.string' => 'Açıklama metin tipinde olmalıdır.',
            'title.string' => 'Başlık metin tipinde olmalıdır.',
            'slug.string' => 'Slug metin tipinde olmalıdır.',
            'image_id.integer' => 'Resim id tam sayı olmalıdır.',
            'image_id.exists' => 'Resim bulunamadı.',
        ];
    }
}
