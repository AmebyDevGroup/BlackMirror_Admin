<?php

namespace App\Console\Commands;

use App\Jobs\SendWeatherJob;
use App\Mirror;
use Illuminate\Console\Command;

class SendWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ws:weather {mirrors_sn*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run weather job';

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
        $mirrors = Mirror::whereIn('serial', $this->argument('mirrors_sn'))
            ->whereHas('features_configs', function ($q) {
                $q->where('feature_id', 4);
                $q->where('active', 1);
            })->with('features_configs')->get();
        foreach ($mirrors as $mirror) {
            $feature_config = $mirror->features_configs->where('feature_id', 4)->first();
            $feature = $feature_config->feature;
            $job = $feature->getJob($feature_config, 'mirror.' . $mirror->serial);
            if ($job) {
                dispatch($job);
            }
        }
    }
}
