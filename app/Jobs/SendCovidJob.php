<?php

namespace App\Jobs;

use App\Events\Message;
use App\MirrorConfig;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCovidJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $config;
    protected $channel_name;

    /**
     * Create a new job instance.
     *
     * @return void
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
        $client = new Client();
        $response = $client->request('GET',
            'https://api.covid19api.com/summary');
        $data = json_decode($response->getBody()->getContents());
        $collection = collect($data->Countries);

        $total_confirmed = 0;
        $total_deaths = 0;
        $total_recovered = 0;
        foreach($collection as $country) {
            $total_confirmed += (int)$country->TotalConfirmed;
            $total_deaths += (int)$country->TotalDeaths;
            $total_recovered += (int)$country->TotalRecovered;
        }
        $poland = $collection->where('Country', 'Poland')->first();

        $covidInfo = [];
        if($this->config->data['type'] == 1 || $this->config->data['type'] == 3) {
            $covidInfo['global'] = [
                'confirmed' => $total_confirmed,
                'deaths' => $total_deaths,
                'recovered' => $total_recovered,
            ];
        }
        if($this->config->data['type'] == 2 || $this->config->data['type'] == 3) {
            $covidInfo['poland'] = [
                'confirmed' => $poland->TotalConfirmed,
                'deaths' => $poland->TotalDeaths,
                'recovered' => $poland->TotalRecovered,
            ];
        }
        return broadcast(new Message('covid', $covidInfo, $this->channel_name));
    }
}
