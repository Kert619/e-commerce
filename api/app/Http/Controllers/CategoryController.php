<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\HttpResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categoryName = $request->input('category_name');

        $perPage = $request->input('per_page', 10);

        $query = Category::query();

        $query = $query->where('category_name', 'LIKE', "%$categoryName%");

        $categories = $query->with(['parentCategory', 'subCategories'])->paginate($perPage);

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $newCategory = Category::create($validated);

        return $this->success(new CategoryResource($newCategory), 'Category created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        $category->update($validated);

        return $this->success(new CategoryResource($category), 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            $this->success(null, 'Category deleted successfully', 204);
        } catch (QueryException $e) {
            //foreign key constraint error
            if ($e->getCode() == '23000') {
                return $this->error('Error deleting. Category has sub categories', 409);
            } else {
                return $this->error('Error deleting. An unexpected error occured', 500);
            }
        }
    }

    public function options()
    {
        $options = Category::query()->get(['id as value', 'category_name as label']);
        return $options;
    }
}
