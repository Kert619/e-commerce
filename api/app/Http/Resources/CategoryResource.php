<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'category_name' => $this->category_name,
            'parent_category_id' => $this->parent_category_id,
            'parent_category' => new CategoryResource($this->whenLoaded('parentCategory')),
            'sub_categories' => CategoryResource::collection($this->whenLoaded('subCategories'))
        ];
    }
}
