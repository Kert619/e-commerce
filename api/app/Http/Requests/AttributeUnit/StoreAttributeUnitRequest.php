<?php

namespace App\Http\Requests\AttributeUnit;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttributeUnitRequest extends FormRequest
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
            'attribute_unit_name' => ['required', 'unique', 'max:255'],
            'attribute_unit_short_name' => ['required', 'unique', 'max:255']
        ];
    }
}
