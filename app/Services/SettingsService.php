<?php

namespace App\Services;

use App\Setting;

class SettingsService
{
    public function getAgeTax()
    {
        $settings = Setting::select("age_aditional")->first();
        return $settings->age_aditional;
    }
}
