<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
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
            'value' => $this->value,
            'product_variant' => new ProductVariantResource($this->whenLoaded('productVariant')),
            'attribute_definition' => new AttributeDefinitionResource($this->whenLoaded('attributeDefinition'))
        ];
    }
}
