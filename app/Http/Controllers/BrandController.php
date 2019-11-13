<?php

namespace App\Http\Controllers;

use App\Brand;
use Exception;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;

class BrandController extends Controller
{
    use ApiResponser;

    public function index()
    {
        try {
            $brands = Brand::all();
            return $this->successResponse($brands, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function store(BrandRequest $request)
    {
        try {
            $brand = Brand::create($request->all());
            return $this->successResponse($brand, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
    public function update(BrandRequest $request, Brand $brand)
    {
        try {
            $brand->update($request->all());
            return $this->successResponse($brand, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();
            return $this->successResponse($brand, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
}
