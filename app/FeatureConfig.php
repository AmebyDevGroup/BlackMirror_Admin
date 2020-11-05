<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeatureConfig extends Model
{
    protected $fillable = [
        'feature_id',
        'user_id',
        'active',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
        'active' => 'boolean'
    ];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
