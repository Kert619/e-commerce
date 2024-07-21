<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeCategory\StoreAttributeCategoryRequest;
use App\Http\Requests\AttributeCategory\UpdateAttributeCategoryRequest;
use App\Http\Resources\AttributeCategoryResource;
use App\Models\AttributeCategory;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class AttributeCategoryController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->all();

        $query = AttributeCategory::query();

        foreach ($filter as $key => $value) {
            $query->where($key, 'LIKE', "%$value%");
        }

        $attributeCategories = $query->get();
        return AttributeCategoryResource::collection($attributeCategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeCategoryRequest $request)
    {
        $validated = $request->validated();
        $newAttributeCategory = AttributeCategory::create($validated);
        return $this->success(new AttributeCategoryResource($newAttributeCategory), 'Attribute category created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(AttributeCategory $attributeCategory)
    {
        return new AttributeCategoryResource($attributeCategory);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeCategoryRequest $request, AttributeCategory $attributeCategory)
    {
        $validated = $request->validated();
        $attributeCategory->update($validated);

        return $this->success(new AttributeCategoryResource($attributeCategory), 'Attribute category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttributeCategory $attributeCategory)
    {
        $attributeCategory->delete();
        $this->success(null, 'Attribute category deleted successfully', 204);
    }
}
