<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Traits\ApiResponser;
use App\Http\Requests\SettingRequest;

class SettingController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $settings = Setting::all();

        return $this->successResponse($settings, 200);
    }

    public function store(SettingRequest $request)
    {
        $setting = Setting::create($request->all());

        return $this->successResponse($setting, 201);
    }

    public function show(Setting $setting)
    {
        return $this->successResponse($setting);
    }

    public function update(SettingRequest $request, Setting $setting)
    {
        $setting->update($request->all());

        return $this->successResponse($setting, 201);
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();

        return $this->successResponse($setting, 200);
    }
}
