<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'daily_rate_free', 'extra_km', 'daily_rate'
    ];

    public function vehicle()
    {
        return $this->hasMany("App\Vehicle");
    }
}
