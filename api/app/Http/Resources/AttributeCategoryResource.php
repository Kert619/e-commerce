<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeCategoryResource extends JsonResource
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
            'attribute_category_name' => $this->attribute_category_name,
            'priority' => $this->priority,
            'attribute_groups' => AttributeGroupResource::collection($this->whenLoaded('attributeGroups')),
            'attribute_definitions' => AttributeDefinitionResource::collection($this->whenLoaded('attributeDefinitions'))
        ];
    }
}
