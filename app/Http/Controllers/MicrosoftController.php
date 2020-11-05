<?php

namespace App\Http\Controllers;

use App\Events\Message;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Beta\Model;
use App\TokenStore\TokenCache;
use Carbon\Carbon;

class MicrosoftController extends Controller
{
    private function initConnection()
    {
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken();
        $graph = new Graph();
        $graph->setApiVersion('beta');
        $graph->setAccessToken($accessToken);
        return $graph;
    }

    public function taskFolders()
    {
        $graph = $this->initConnection();
        $queryParams = array(
            '$top' => 100,
        );
        $getEventsUrl = '/me/outlook/taskFolders?' . http_build_query($queryParams);
        try {
            $folders = $graph->createRequest('GET', $getEventsUrl)
                ->setReturnType(Model\OutlookTaskFolder::class)
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
}
