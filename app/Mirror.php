<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mirror extends Model
{
    protected $fillable = [
        'sn',
        'user_id',
        'active',
        'name'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sensorData(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MirrorSensorData::class);
    }

    public function getSensorData(string $source): \Illuminate\Database\Eloquent\Collection
    {
        return $this->sensorData()->where('source', $source)->get();
    }
}
