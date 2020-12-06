<?php

namespace App\Jobs;

use App\Events\Message;
use App\MirrorConfig;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTimeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $config;
    protected $feature_config;
    protected $channel_name;

    /**
     * Create a new job instance.
     *
     * @return void
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
        $timeInfo = [
            'timestamp' => Carbon::now()->setTimezone($this->config['timezone'])->timestamp,
            'timezone' => $this->config['timezone'],
            'time_format' => $this->config['time-format'],
            'isBritishTime' => $this->config['time-format'] == "HH:mm" ? false : true
        ];
        broadcast(new Message('time', $timeInfo, $this->channel_name));
    }
}
