<?php

namespace App\Jobs;

use App\Events\Message;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendConfigJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $channel_name;

    /**
     * Create a new job instance.
     *
     * @param $user
     * @param $channel_name
     */
    public function __construct($user, $channel_name)
    {
        $this->user = $user;
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
            broadcast(new Message('config',
                    $this->user->getConfig(),
                    $this->channel_name)
            );
        } catch (Exception $e) {
            broadcast(new Message('config', [
                "status" => 'failed',
                "message" => $e->getMessage()
            ], $this->channel_name));
        }
    }
}
