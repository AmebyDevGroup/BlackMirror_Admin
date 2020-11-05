<?php

namespace App\Providers;

use App\MirrorConfig;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use mysql_xdevapi\Exception;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // try {
        //     $config = MirrorConfig::all();
        //     $array_config = [];
        //     foreach ($config as $config_object) {
        //         $array_config[$config_object->name] = $config_object;
        //         Config::set("mirror.{$config_object->name}", $config_object->data);
        //         Config::set("mirror.{$config_object->name}.enabled", $config_object->active);
        //     }
        //     View::share('config', $array_config);
        // } catch (Exception $e) {
        //     View::share('config', config('mirror'));
        // }
    }
}
