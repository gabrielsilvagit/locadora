<?php

namespace App\Http\Controllers;

use Exception;
use App\Setting;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Requests\SettingRequest;

class SettingController extends Controller
{
    use ApiResponser;

    public function index()
    {
        try {
            $settings = Setting::all();
            return $this->successResponse($settings, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function store(SettingRequest $request)
    {
        try {
            $setting = Setting::create($request->all());
            return $this->successResponse($setting, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
    public function update(SettingRequest $request, Setting $setting)
    {
        try {
            $setting->update($request->all());
            return $this->successResponse($setting, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function destroy(Setting $setting)
    {
        try {
            $setting->delete();
            return $this->successResponse($setting, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
}
