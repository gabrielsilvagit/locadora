<?php

namespace App\Http\Controllers;

use Exception;
use App\Category;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $categories = Category::all();
        return $this->successResponse($categories, 200);
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());
        return $this->successResponse($category, 201);
    }

    public function show(Category $category)
    {
        return $this->successResponse($category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->all());
        return $this->successResponse($category, 201);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $this->successResponse($category, 200);
    }


}
