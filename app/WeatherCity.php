<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeatherCity extends Model
{
    protected $fillable = [
        'ext_id',
        'name',
        'country',
        'coord',
    ];

    protected $casts = [
        'coord' => 'array'
    ];
}
