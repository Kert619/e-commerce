<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeGroupResource extends JsonResource
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
            'attribute_group_name' => $this->attribute_group_name,
            'priority' => $this->priority,
            'attribute_category' => new AttributeCategoryResource($this->whenLoaded('attributeCategory')),
            'attribute_definitions' => AttributeDefinitionResource::collection($this->whenLoaded('attributeDefinitions'))
        ];
    }
}
