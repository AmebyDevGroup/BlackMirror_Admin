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
                    'confirmed' => $this->nice_number($data->Global->TotalConfirmed),
                    'deaths' => $this->nice_number($data->Global->TotalDeaths),
                    'recovered' => $this->nice_number($data->Global->TotalRecovered),
                ];
                $poland = [
                    'confirmed' => $this->nice_number($poland_item->TotalConfirmed),
                    'deaths' => $this->nice_number($poland_item->TotalDeaths),
                    'recovered' => $this->nice_number($poland_item->TotalRecovered),
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

    private function nice_number($n)
    {
        $n = (0 + str_replace(",", "", $n));
        if (!is_numeric($n)) return false;
        if ($n > 1000000000000) return round(($n / 1000000000000), 2) . ' bln';
        elseif ($n > 1000000000) return round(($n / 1000000000), 2) . ' mld';
        elseif ($n > 1000000) return round(($n / 1000000), 2) . ' mln';
        elseif ($n > 1000) return round(($n / 1000), 2) . ' tys';

        return number_format($n);
    }
}
