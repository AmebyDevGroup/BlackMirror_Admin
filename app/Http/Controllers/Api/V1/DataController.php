<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Routing\Controller as BaseController;

class DataController extends BaseController
{
    public function getChangelog()
    {
        try {
            $apps = [
                'Panel Administracyjny' => 'https://api.github.com/repos/AmebyDevGroup/BlackMirror_Admin/commits',
                'Aplikacja Mobilna' => 'https://api.github.com/repos/AmebyDevGroup/BlackMirror_Mobile/commits',
                'Aplikacja Kliencka' => 'https://api.github.com/repos/AmebyDevGroup/BlackMirror_Client/commits'
            ];
            $commits = Cache::remember('Api::commits', 3600, function () use ($apps) {
                $commits = [];
                foreach ($apps as $app => $url) {
                    $client = new Client();
                    $response = $client->request('GET',
                        $url);
                    $data = json_decode($response->getBody()->getContents());
                    $commits[$app] = collect(array_slice($data, 0, 12))
                        ->pluck('commit')
                        ->map(function ($item) {
                            return [
                                'author' => $item->author->name,
                                'date' => Carbon::parse($item->author->date)->format('Y-m-d H:i:s'),
                                'message' => $item->message
                            ];
                        });
                }
                return $commits;
            });

            return response()->json([
                'success' => true,
                'message' => null,
                'data' => $commits
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
