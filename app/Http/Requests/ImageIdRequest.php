<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageIdRequest extends FormRequest
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
            'id' => 'required|integer|exists:images,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Image id is required',
            'id.integer' => 'Image id must be an integer',
            'id.exists' => 'Image not found',
        ];
    }
}
