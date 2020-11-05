<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Feature extends Model
{
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

    public function getRouteKeyName()
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
        if(view()->exists('panel.features.'.$this->slug)) {
            return view('panel.features.'.$this->slug, ['feature' => $this, 'config' => $this->getConfig]);
        } else {
            return view('panel.features.default', ['feature' => $this, 'config' => $this->getConfig]);
        }
    }

    public function getJob($feature_config, $channel_name)
    {
        $job_class = 'App\Jobs\Send'.Str::studly($this->slug).'Job';
        if(class_exists($job_class)){
            return new $job_class($feature_config, $channel_name);
        }
        return false;
    }
}
