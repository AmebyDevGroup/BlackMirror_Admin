<?php


namespace App\Http\Controllers;

use App\Events\Message;
use App\Feature;
use App\Jobs\SendConfigJob;
use App\Mirror;
use App\TokenStore\TokenCache;
use Beta\Microsoft\Graph\Model\OutlookTaskFolder;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Microsoft\Graph\Graph;

class ConfigurationController extends BaseController
{
    public function setPageMode($mode = 'light-mode')
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }
        $user->params = array_merge($user->params ?? [], ['page-mode' => $mode]);
        $user->save();
    }

    public function setActive(Feature $feature, $active = 1)
    {
        $old_active = $feature->getConfig->active;
        $feature->getConfig->update(['active' => (int)$active]);
        foreach (auth()->user()->mirrors as $mirror) {
            dispatch(new SendConfigJob(auth()->user(), 'mirror.' . $mirror->serial));
            if ($active == 1 && $old_active != $active) {
                $job = $feature->getJob($feature->getConfig, 'mirror.' . $mirror->serial);
                if ($job) {
                    dispatch($job);
                }
            }
        }
        $message = "Wyłączono widget";
        if ($active) {
            $message = "Włączono widget";
        }
        return response()->json(['status' => 'success', 'message' => $message]);
    }

    public function getConfigurationForm(Feature $feature)
    {
        return $feature->configurationForm();
    }

    public function sendConfigurationForm(Request $request, Feature $feature)
    {
        $feature->getConfig()->update($request->except('_token'));
        if ($feature->getConfig->active) {
            foreach (auth()->user()->mirrors as $mirror) {
                dispatch($feature->getJob($feature->getConfig, 'mirror.' . $mirror->serial));
            }
        }
        return response()->json(['status' => 'success', 'message' => "Pomyślnie zapisano konfigurację"]);
    }

    public function getAirStations()
    {
        //http://api.gios.gov.pl/pjp-api/rest/station/findAll
        $client = new Client();
        $response = $client->request('GET', 'http://api.gios.gov.pl/pjp-api/rest/station/findAll');
        return response()->json(collect(json_decode($response->getBody()->getContents()))
            ->sortBy('stationName')->pluck('stationName', 'id'));
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

    public function getTasksFolder()
    {
        $graph = $this->initConnection();
        $queryParams = array(
            '$top' => 100,
        );
        $getEventsUrl = '/me/outlook/taskFolders?' . http_build_query($queryParams);
        try {
            $folders = $graph->createRequest('GET', $getEventsUrl)
                ->setReturnType(OutlookTaskFolder::class)
                ->execute();
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'data' => $e->getMessage()
            ];
        }
        $formatedFolders = [];
        foreach ($folders as $folder) {
            $this_folder = [
                'id' => $folder->getId(),
                'title' => $folder->getName()
            ];
            $formatedFolders[] = $this_folder;
        }
        return [
            'status' => 'success',
            'data' => $formatedFolders
        ];
    }

    public function sendBacklightMessage($serial, $status)
    {
        broadcast(new Message('backlightStatus', [
            'power' => $status == 'on'
        ], 'mirror.' . $serial));

        return redirect()->back();
    }

    public function sendSystemUpdateMessage($serial, $status)
    {
        broadcast(new Message('systemUpdate', [
            'systemUpdate' => $status == 'true'
        ], 'mirror.' . $serial));

        return redirect()->back();
    }
}
