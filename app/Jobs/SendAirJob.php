<?php

namespace App\Jobs;

use App\Events\Message;
use App\MirrorConfig;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAirJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // http://api.gios.gov.pl/pjp-api/rest/station/sensors/{stationId}
    protected $getStationUrl;
    // http://api.gios.gov.pl/pjp-api/rest/data/getData/{sensorId}
    protected $getSensorUrl;
    // http://api.gios.gov.pl/pjp-api/rest/aqindex/getIndex/{stationId}
    protected $getIndexUrl;

    protected $channel_name;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($feature_config, $channel_name)
    {
        $this->getIndexUrl = "http://api.gios.gov.pl/pjp-api/rest/aqindex/getIndex/" . $feature_config->data['station'] ?? '';
        $this->getStationUrl = "http://api.gios.gov.pl/pjp-api/rest/station/sensors/" . $feature_config->data['station'] ?? '';
        $this->getSensorUrl = "http://api.gios.gov.pl/pjp-api/rest/data/getData/";
        $this->channel_name = $channel_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $client = new Client();
            $airInfo = [];
            $response = $client->request('GET', $this->getIndexUrl);
            $data = json_decode($response->getBody()->getContents());
            $airInfo['main'] = [
                'date' => $data->stCalcDate,
                'quality_id' => $data->stIndexLevel->id,
                'quality_message' => $data->stIndexLevel->indexLevelName,
            ];
            $response = $client->request('GET', $this->getStationUrl);
            foreach (json_decode($response->getBody()->getContents()) as $station) {
                $sensor = $client->request('GET', $this->getSensorUrl . $station->id);
                $airInfo['details'][] = [
                    'name' => ucfirst($station->param->paramName),
                    'code' => $station->param->paramCode,
                    'value' => json_decode($sensor->getBody()->getContents())->values[0] ?? false
                ];
            }
            return broadcast(new Message('air', $airInfo, $this->channel_name));
        } catch (Exception $e) {
            return broadcast(new Message('air', [
                "status" => 'failed',
                "message" => $e->getMessage()
            ], $this->channel_name));
        }
    }
}
