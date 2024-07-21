<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
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
            'product_variant_name' => $this->product_variant_name,
            'sku' => $this->sku,
            'price' => $this->price,
            'discounted_price' => $this->discounted_price,
            'is_discounted' => $this->is_discounted,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'product' => new ProductResource($this->whenLoaded('product')),
            'attributes' => AttributeResource::collection($this->whenLoaded('attributes'))
        ];
    }
}
