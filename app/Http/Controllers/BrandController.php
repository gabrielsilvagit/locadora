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
        $brands = Brand::all();
        return $this->successResponse($brands, 200);
    }

    public function store(BrandRequest $request)
    {
        $brand = Brand::create($request->all());
        return $this->successResponse($brand, 201);
    }

    public function show(Brand $brand)
    {
        return $this->successResponse($brand);
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $brand->update($request->all());
        return $this->successResponse($brand, 201);
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return $this->successResponse($brand, 200);
    }
}
