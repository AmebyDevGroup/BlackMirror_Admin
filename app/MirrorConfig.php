<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MirrorConfig extends Model
{
    protected $fillable = [
        'name',
        'active',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
        'active' => 'boolean'
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }
}
