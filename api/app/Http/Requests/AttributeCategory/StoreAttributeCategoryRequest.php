<?php

namespace App\Http\Requests\AttributeCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttributeCategoryRequest extends FormRequest
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
            'attribute_category_name' => ['required', 'max:255', 'unique:attribute_categories,attribute_category_name'],
            'priority' => ['required', 'integer', 'min:1']
        ];
    }
}
