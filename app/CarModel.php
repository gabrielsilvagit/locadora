<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $fillable = [
        'name', 'brand_id'
    ];

    public function vehicle()
    {
        return $this->hasMany("App\Vehicle");
    }

    public function brand()
    {
        return $this->belongsTo("App\Brand", "id", "brand_id");
    }
}
