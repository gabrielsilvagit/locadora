<?php

namespace App;

use App\Services\AvailabilityService;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'plate', 'chassi', 'carmodel_id', 'model_year', 'make_year', 'fuel_id', 'category_id',
    ];

    protected $with = [
        'carmodel', 'fuel', 'category',
    ];

    public function rental()
    {
        return $this->hasMany("App\Rental");
    }

    public function carmodel()
    {
        return $this->belongsTo("App\CarModel", 'carmodel_id', 'id');
    }

    public function fuel()
    {
        return $this->belongsTo("App\Fuel", 'fuel_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo("App\Category", 'category_id', 'id');
    }

    // public function getRentedAttribute(AvailabilityService $service)
    // {
    //     return !$service->available($this->id);
    // }
}
