<?php

namespace App\Services;

use App\Category;

class CategoryService
{
    public function getDailyRate($category, $free_km)
    {
        $category = Category::select("daily_rate", "free_daily_rate")
            ->where("id", $category)
            ->first();
        if ($free_km) {
            return $category->free_daily_rate;
        }

        return $category->daily_rate;
    }
}
