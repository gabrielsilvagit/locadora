<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    protected $fillable = [
        'name', 'price'
    ];

    public function vehicle()
    {
        return $this->hasMany("App\Vehicle");
    }
}
