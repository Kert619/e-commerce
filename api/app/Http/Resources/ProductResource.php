<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'product_name' => $this->product_name,
            'description' => $this->description,
            'featured' => $this->featured,
            'category' => CategoryResource::collection($this->whenLoaded('category')),
            'product_variants' => ProductVariantResource::collection($this->whenLoaded('productVariants'))
        ];
    }
}
