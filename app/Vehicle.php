<?php

namespace App;

use App\Services\AvailabilityService;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'plate', 'chassi', 'carmodel_id', 'model_year', 'make_year', 'fuel_id', 'category_id',
    ];

    public function rental()
    {
        return $this->hasMany("App\Rental");
    }

    public function carmodel()
    {
        return $this->belongsTo("App\CarModel", "id", "carmodel_id");
    }

    public function fuel()
    {
        return $this->belongsTo("App\Fuel", "id", "fuel_id");
    }

    public function category()
    {
        return $this->belongsTo("App\Category", "id", "category_id");
    }

    public function getRentedAttribute(AvailabilityService $service)
    {
        return !$sevice->avaliable($this->id);
    }
}
