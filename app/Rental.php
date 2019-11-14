<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
        'type', 'user_id', 'vehicle_id', 'start_date', 'end_date', 'daily_rate', 'notes', 'current_km', 'fuel_level', 'limited'
    ];

    public function user()
    {
        return $this->belongsTo("App\User", "id", "user_id");
    }

    public function vehicle()
    {
        return $this->hasOne("App\Vehicle", "id", "vehicle_id");
    }

    public function dropoff()
    {
        return $this->hasOne("App\DropOff");
    }
}
