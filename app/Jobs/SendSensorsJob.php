<?php

namespace App\Jobs;

use App\Events\Message;
use App\Mirror;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSensorsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $config;
    protected $feature_config;
    protected $channel_name;

    /**
     * Create a new job instance.
     *
     * @param $feature_config
     * @param $channel_name
     */
    public function __construct($feature_config, $channel_name)
    {
        $this->feature_config = $feature_config;
        $this->config = $feature_config->data;
        $this->channel_name = $channel_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mirrorSN = explode('.', $this->channel_name);
        $mirror = Mirror::where('serial', $mirrorSN[1] ?? null)->first();
        if ($mirror) {
            $sensorData = $mirror->sensorData()
                ->where('source', 'temp_sensor')
                ->orderBy('created_at', 'DESC')
                ->first();
            if ($sensorData) {
                $tempInInfo = [
                    'temperature' => (float)round($sensorData->data['temp'], 2),
                    'humidity' => (float)round($sensorData->data['humidity'], 2),
                    'pressure' => (float)round($sensorData->data['pressure'], 4)
                ];
            } else {
                $tempInInfo = [
                    'temperature' => (float)0.00,
                    'humidity' => (float)0.00,
                    'pressure' => (float)0.00
                ];
            }
            broadcast(new Message('sensors', $tempInInfo, $this->channel_name));
        } else {
            broadcast(new Message('sensors', [
                "status" => 'failed',
                "message" => "Mirror doesn't exist"
            ], $this->channel_name));
        }

    }
}
