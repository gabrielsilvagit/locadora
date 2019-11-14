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
        try {
            $categories = Category::all();
            return $this->successResponse($categories, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function store(CategoryRequest $request)
    {
        try {
            // dd($request->all());
            $category = Category::create($request->all());
            return $this->successResponse($category, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $category->update($request->all());
            return $this->successResponse($category, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return $this->successResponse($category, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }


}
