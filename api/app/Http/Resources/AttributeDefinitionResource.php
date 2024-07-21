<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeDefinitionResource extends JsonResource
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
            'attribute_definition_name' => $this->attribute_definition_name,
            'attribute_definition_short_name' => $this->attribute_definition_short_name,
            'priority' => $this->priority,
            'attribute_category' => new AttributeCategoryResource($this->whenLoaded('attributeCategory')),
            'attribute_group' => new AttributeGroupResource($this->whenLoaded('attributeGroup')),
            'attribute_unit' => new AttributeUnitResource($this->whenLoaded('attributeUnit'))
        ];
    }
}
