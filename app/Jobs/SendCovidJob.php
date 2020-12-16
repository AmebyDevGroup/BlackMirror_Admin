<?php

namespace App\Jobs;

use App\Events\Message;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class SendCovidJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $config;
    protected $channel_name;

    /**
     * Create a new job instance.
     *
     * @param $feature_config
     * @param $channel_name
     */
    public function __construct($feature_config, $channel_name)
    {
        $this->config = $feature_config;
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
            [$global, $poland] = Cache::remember('JOB::SendCovidData', 43200, function () {
                $client = new Client();
                $response = $client->request('GET',
                    'https://api.covid19api.com/summary');
                $data = json_decode($response->getBody()->getContents());
                $collection = collect($data->Countries);
                $poland_item = $collection->where('Country', 'Poland')->first();

                $global = [
                    'confirmed' => (int)$data->Global->TotalConfirmed,
                    'deaths' => (int)$data->Global->TotalDeaths,
                    'recovered' => (int)$data->Global->TotalRecovered
                ];
                $poland = [
                    'confirmed' => $poland_item->TotalConfirmed,
                    'deaths' => $poland_item->TotalDeaths,
                    'recovered' => $poland_item->TotalRecovered,
                ];
                return [$global, $poland];
            });
            $covidInfo = [];
            if ($this->config->data['type'] == 1 || $this->config->data['type'] == 3) {
                $covidInfo['global'] = $global;
            }
            if ($this->config->data['type'] == 2 || $this->config->data['type'] == 3) {
                $covidInfo['poland'] = $poland;
            }
            broadcast(new Message('covid', $covidInfo, $this->channel_name));
        } catch (Exception $e) {
            broadcast(new Message('covid', [
                "status" => 'failed',
                "message" => $e->getMessage()
            ], $this->channel_name));
        }
    }
}
