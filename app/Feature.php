<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Feature extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'name',
        'active',
        'icon',
    ];

    protected $casts = [
        'active' => 'boolean',
        'base_config' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function config()
    {
        return $this->hasOne(FeatureConfig::class)->where('user_id', auth()->user()->id);
    }

    public function getConfig()
    {
        if(!$this->config){
            $this->config()->create([
                'user_id' => auth()->user()->id,
                'active' => 0,
                'data'=>$feature->base_config??[]
            ]);
        }
        return $this->config();
    }

    public function configurationForm()
    {
        if (view()->exists('panel.features.' . $this->slug)) {
            return view('panel.features.' . $this->slug, ['feature' => $this, 'config' => $this->getConfig]);
        }

        return view('panel.features.default', ['feature' => $this, 'config' => $this->getConfig]);
    }

    public function getConfigRule()
    {
        switch ($this->slug) {
            case 'tasks':
                return [
                    'provider' => 'required',
                    'directory' => 'required'
                ];
            case 'calendar':
                return [
                    'provider' => 'required'
                ];
            case 'news':
                return [
                    'rss' => 'required'
                ];
            case 'weather':
                return [
                    'city' => 'required'
                ];
            case 'air':
                return [
                    'station' => 'required'
                ];
            case 'covid':
                return [
                    'type' => 'required|in:1,2,3'
                ];
            case 'time':
                return [
                    'timezone' => 'required',
                    'time-format' => 'required|in:HH:mm,hh:mm A'
                ];
            case 'sensors':
            case 'camera':
            default:
                return [];
        }
    }

    public function getJob($feature_config, $channel_name)
    {
        $job_class = 'App\Jobs\Send' . Str::studly($this->slug) . 'Job';
        if (class_exists($job_class)) {
            return new $job_class($feature_config, $channel_name);
        }
        return false;
    }
}
