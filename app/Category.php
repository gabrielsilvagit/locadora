<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'free_daily_rate', 'daily_rate', 'extra_km_price'
    ];

    public function vehicle()
    {
        return $this->hasMany("App\Vehicle");
    }

    public function category()
    {
        return $this->hasMany("App\Rental");
    }
}
