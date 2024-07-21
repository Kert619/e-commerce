<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeGroup\StoreAttributeGroupRequest;
use App\Http\Requests\AttributeGroup\UpdateAttributeGroupRequest;
use App\Http\Resources\AttributeGroupResource;
use App\Models\AttributeGroup;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class AttributeGroupController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->all();

        $query = AttributeGroup::query();

        foreach ($filter as $key => $value) {
            $query->where($key, 'LIKE', "%$value%");
        }

        $attributeGroups = $query->get();
        return AttributeGroupResource::collection($attributeGroups);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeGroupRequest $request)
    {
        $validated = $request->validated();
        $newAttributeGroup = AttributeGroup::create($validated);
        return $this->success(new AttributeGroupResource($newAttributeGroup), 'Attribute group created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(AttributeGroup $attributeGroup)
    {
        return new AttributeGroupResource($attributeGroup);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeGroupRequest $request, AttributeGroup $attributeGroup)
    {
        $validated = $request->validated();
        $attributeGroup->update($validated);

        return $this->success(new AttributeGroupResource($attributeGroup), 'Attribute group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttributeGroup $attributeGroup)
    {
        $attributeGroup->delete();
        $this->success(null, 'Attribute group deleted successfully', 204);
    }
}
