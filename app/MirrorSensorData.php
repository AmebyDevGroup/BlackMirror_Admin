<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MirrorSensorData extends Model
{
    protected $fillable = [
        'source',
        'data',
    ];

    protected $casts = [
        'data' => 'json'
    ];

    public function mirror(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Mirror::class);
    }
}
