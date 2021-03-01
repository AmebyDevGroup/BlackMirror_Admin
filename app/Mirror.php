<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mirror extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'serial',
        'active',
        'name'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function features_configs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FeatureConfig::class, 'user_id', 'user_id');
    }

    public function sensorData(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MirrorSensorData::class);
    }

    public function getSensorData(string $source, $order = 'asc', $only_one = false)
    {
        if ($only_one) {
            return $this->sensorData()->where('source', $source)->orderBy('id', $order)->first();
        }
        return $this->sensorData()->where('source', $source)->orderBy('id', $order)->get();
    }

    public function getWiFiConnectionQuality()
    {
        $data = $this->getSensorData('wifi_sensor', 'desc', true);
        $q = (int)$data?->data['quality'] ?? 0;
        switch ($q) {
            case ($q <= 25):
                return "wifi-0";
            case ($q <= 50):
                return "wifi-1";
            case ($q <= 75):
                return "wifi-2";
            case ($q <= 100):
                return "wifi-3";
        }
        return '';
    }

    public function getWiFiConnectionName()
    {
        $data = $this->getSensorData('wifi_sensor', 'desc', true);
        if ($data) {
            if (isset($data->data['nazwa'])) {
                return $data->data['nazwa'] ?: 'Nazwa nieznana';
            }
        }
    }

    public function getBacklightStatus()
    {
        $data = $this->getSensorData('backlight_sensor', 'desc', true);
        if ($data) {
            if (isset($data->data['status'])) {
                return $data->data['status'] == 'on' ? true : false;
            }
        }
    }
}
