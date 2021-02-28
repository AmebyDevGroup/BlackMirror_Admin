<?php

namespace App\Console\Commands;

use App\Jobs\SendAirJob;
use App\Mirror;
use Illuminate\Console\Command;

class SendData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ws:send-data {mirrors_sn*} {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run AirQuality job';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->option('id');
        $mirrors = Mirror::whereIn('serial', $this->argument('mirrors_sn'))
            ->whereHas('features_configs', function ($q) use ($id) {
                $q->where('feature_id', $id);
                $q->where('active', 1);
            })->with('features_configs')->get();
        foreach ($mirrors as $mirror) {
            $feature_config = $mirror->features_configs->where('feature_id', $id)->first();
            $feature = $feature_config->feature;
            $job = $feature->getJob($feature_config, 'mirror.' . $mirror->serial);
            if ($job) {
                dispatch($job);
            }
        }
    }
}
