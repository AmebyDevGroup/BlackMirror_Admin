<?php

namespace App\Http\Controllers;

use App\Events\Message;
use App\MirrorConfig;
use App\WeatherCity;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Jobs;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function welcome()
    {
        return view('welcome');
    }

    public function help()
    {
        return view('help');
    }

    public function saveConfig(Request $request)
    {
        foreach ($request->except('_token') as $slug => $config) {
            $db_config = MirrorConfig::where('name', $slug)->first();
            if ($db_config) {
                $db_config->update([
                    'active' => $config['enabled'] ?? 0,
                    'data' => $config
                ]);
            } else {
                MirrorConfig::create([
                    'name' => $slug,
                    'active' => $config['enabled'] ?? 0,
                    'data' => $config
                ]);
            }
        }
        $config = MirrorConfig::all();
        $message = [];
        foreach ($config as $config_object) {
            $val = false;
            if ($config_object->active) {
                $val = true;
            }
            $message[$config_object->name] = $val;
        }
        broadcast(new Message('config', $message));
        $this->forceSync();
        return redirect()->back();
    }

    public function loadMicrosoftViewData()
    {
        $viewData = [];
        // Check for flash errors
        if (session('error')) {
            $viewData['error'] = session('error');
            $viewData['errorDetail'] = session('errorDetail');
        }
        // Check for logged on user
        if (session('userName')) {
            $viewData['userName'] = session('userName');
            $viewData['userEmail'] = session('userEmail');
        }
        return $viewData;
    }
}
