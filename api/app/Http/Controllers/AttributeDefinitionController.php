<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeDefinition\StoreAttributeDefinitionRequest;
use App\Http\Requests\AttributeDefinition\UpdateAttributeDefinitionRequest;
use App\Http\Resources\AttributeDefinitionResource;
use App\Models\AttributeDefinition;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class AttributeDefinitionController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->all();

        $query = AttributeDefinition::query();

        foreach ($filter as $key => $value) {
            $query->where($key, 'LIKE', "%$value%");
        }

        $attributeDefinitions = $query->get();
        return AttributeDefinitionResource::collection($attributeDefinitions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeDefinitionRequest $request)
    {
        $validated = $request->validated();
        $newAttributeDefinition = AttributeDefinition::create($validated);
        return $this->success(new AttributeDefinitionResource($newAttributeDefinition), 'Attribute definition created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(AttributeDefinition $attributeDefinition)
    {
        return new AttributeDefinitionResource($attributeDefinition);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeDefinitionRequest $request, AttributeDefinition $attributeDefinition)
    {
        $validated = $request->validated();
        $attributeDefinition->update($validated);

        return $this->success(new AttributeDefinitionResource($attributeDefinition), 'Attribute definition updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttributeDefinition $attributeDefinition)
    {
        $attributeDefinition->delete();
        $this->success(null, 'Attribute definition deleted successfully', 204);
    }
}
