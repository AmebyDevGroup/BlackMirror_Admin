<?php


namespace App\Http\Controllers;

use App\Feature;
use App\Jobs\SendConfigJob;
use App\TokenStore\TokenCache;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class ConfigurationController extends BaseController
{
    public function setPageMode($mode = 'light-mode')
    {
        $user = Auth::user();
        if(!$user) {
            abort(403);
        }
        $user->params = array_merge($user->params??[], ['page-mode'=>$mode]);
        $user->save();
    }

    public function setActive(Feature $feature, $active = 1)
    {
        $old_active = $feature->getConfig->active;
        $feature->getConfig->update(['active' => (int)$active]);
        dispatch(new SendConfigJob(auth()->user(), 'mirror.123'));
        if ($active == 1 && $old_active != $active) {
            dispatch($feature->getJob($feature->getConfig, 'mirror.123'));
        }
    }

    public function getConfigurationForm(Feature $feature)
    {
        return $feature->configurationForm();
    }

    public function sendConfigurationForm(Request $request, Feature $feature)
    {
        $feature->getConfig()->update($request->except('_token'));
        if ($feature->getConfig->active) {
            dispatch($feature->getJob($feature->getConfig, 'mirror.123'));
        }
        return response()->json(['status'=>'success', 'message'=>"Pomyślnie zapisano konfigurację"]);
    }

    public function getAirStations()
    {
        //http://api.gios.gov.pl/pjp-api/rest/station/findAll
        $client = new Client();
        $response = $client->request('GET', 'http://api.gios.gov.pl/pjp-api/rest/station/findAll');
        return response()->json(collect(json_decode($response->getBody()->getContents()))->sortBy('stationName')->pluck('stationName',
            'id'));
    }

    private function initConnection()
    {
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken();
        $graph = new Graph();
        $graph->setApiVersion('beta');
        $graph->setAccessToken($accessToken);
        return $graph;
    }

    public function getTasksFolder($provider)
    {
        $folders = ['status' => 'error', 'data'=>'Wybrany dostawca usługi nie jest obsługiwany'];
        switch ($provider) {
            case 'microsoft':
                $folders = app('\App\Http\Controllers\MicrosoftController')->taskFolders();
                break;
            default:
                break;
        }
        return response()->json($folders);
    }
}
