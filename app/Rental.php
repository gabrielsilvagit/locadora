<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
        'type', 'user_id', 'category_id', 'start_date', 'end_date', 'daily_rate', 'notes',
        'current_km', 'fuel_level', 'free_km', 'vehicle_id', 'age_aditional'
    ];

    protected $with = ['user', 'category', 'vehicle'];

    public function user()
    {
        return $this->belongsTo("App\User", 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo("App\Category", 'category_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo("App\Vehicle", 'vehicle_id', 'id');
    }

    public function dropoff()
    {
        return $this->hasOne("App\DropOff");
    }
}
