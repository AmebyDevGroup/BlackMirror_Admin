<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Routing\Controller as BaseController;

class DataController extends BaseController
{
    public function getChangelog()
    {
        try {
            $client = new Client();
            $response = $client->request('GET',
                'https://api.github.com/repos/KrzychuW/BlackMirror/commits');
            $data = json_decode($response->getBody()->getContents());
            $commits = collect(array_slice($data, 0, 12))->pluck('commit')->map(function ($item) {
                return [
                    'author' => $item->author->name,
                    'date' => Carbon::parse($item->author->date)->format('Y-m-d H:i:s'),
                    'message' => $item->message
                ];
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
