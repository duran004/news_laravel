<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:90',
            'main_category_id' => 'required|integer|exists:main_categories,id',
            'image_id' => 'nullable|integer|exists:images,id',
            'slug' => 'required|string|max:90|unique:categories,slug'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Kategori adı zorunludur.',
            'name.string' => 'Kategori adı metin tipinde olmalıdır.',
            'name.max' => 'Kategori adı en fazla 90 karakter olmalıdır.',
            'main_category_id.required' => 'Ana kategori id zorunludur.',
            'main_category_id.integer' => 'Ana kategori id tam sayı olmalıdır.',
            'main_category_id.exists' => 'Ana kategori bulunamadı.',
            'image_id.integer' => 'Resim id tam sayı olmalıdır.',
            'image_id.exists' => 'Resim bulunamadı.',
            'slug.required' => 'Slug zorunludur.',
            'slug.string' => 'Slug metin tipinde olmalıdır.',
            'slug.max' => 'Slug en fazla 90 karakter olmalıdır.',
            'slug.unique' => 'Slug benzersiz olmalıdır.'
        ];
    }
}
