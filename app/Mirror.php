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
}
