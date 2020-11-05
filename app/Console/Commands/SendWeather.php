<?php

namespace App\Console\Commands;

use App\Jobs\SendWeatherJob;
use Illuminate\Console\Command;

class SendWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ws:weather';

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
        dispatch(new SendWeatherJob());
    }
}
