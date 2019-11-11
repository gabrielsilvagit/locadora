<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DropOff extends Model
{
    protected $fillable = [
        'end_date', 'damage', 'damage_notes', 'clean', 'clean_notes', 'fuel_level', 'current_km', 'rental_id'
    ];

    public function rental()
    {
        return $this->belongsTo("App\Rental", "id", "rental_id");
    }
}
