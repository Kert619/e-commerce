<?php

namespace App\Http\Requests\AttributeDefinition;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributeDefinitionRequest extends FormRequest
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
            'attribute_definition_name' => ['required', 'max:255'],
            'attribute_definition_short_name' => ['required', 'max:255'],
            'attribute_category_id' => ['nullable', 'exists:attribute_categories,id'],
            'attribute_group_id' => ['nullable', 'exists:attribute_groups,id'],
            'attribute_unit_id' => ['required', 'exists:attribute_units,id'],
            'priority' => ['required', 'integer', 'min:1']
        ];
    }
}
