<?php

namespace App\Http\Requests\AttributeGroup;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttributeGroupRequest extends FormRequest
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
            'attribute_group_name' => ['required', 'max:255'],
            'attribute_category_id' => ['required', 'exists:attribute_categories,id'],
            'priority' => ['required', 'integer', 'min:1'],
            'presentation_format' => ['required', Rule::in(['default', 'range', 'combined', 'ratio', 'boolean', 'list', 'text'])]
        ];
    }
}
