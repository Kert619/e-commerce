<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeUnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'attribute_unit_name' => $this->attribute_unit_name,
            'attribute_unit_short_name' => $this->attribute_unit_short_name,
            'attribute_definitions' => AttributeDefinitionResource::collection($this->whenLoaded('attributeDefinitions'))
        ];
    }
}
