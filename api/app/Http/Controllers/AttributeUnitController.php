<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeUnit\StoreAttributeUnitRequest;
use App\Http\Requests\AttributeUnit\UpdateAttributeUnitRequest;
use App\Http\Resources\AttributeUnitResource;
use App\Models\AttributeUnit;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class AttributeUnitController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->all();

        $query = AttributeUnit::query();

        foreach ($filter as $key => $value) {
            $query->where($key, 'LIKE', "%$value%");
        }

        $attributeUnits = $query->get();
        return AttributeUnitResource::collection($attributeUnits);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeUnitRequest $request)
    {
        $validated = $request->validated();
        $newAttributeUnit = AttributeUnit::create($validated);
        return $this->success(new AttributeUnitResource($newAttributeUnit), 'Attribute unit created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(AttributeUnit $attributeUnit)
    {
        return new AttributeUnitResource($attributeUnit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeUnitRequest $request, AttributeUnit $attributeUnit)
    {
        $validated = $request->validated();
        $attributeUnit->update($validated);

        return $this->success(new AttributeUnitResource($attributeUnit), 'Attribute unit updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttributeUnit $attributeUnit)
    {
        $attributeUnit->delete();
        $this->success(null, 'Attribute unit deleted successfully', 204);
    }

    public function options()
    {
        $options = AttributeUnit::query()->get(['id as value', 'attribute_unit_name as label']);
        return $options;
    }
}
