<?php

namespace App\Console\Commands;

use App\Jobs\SendNewsJob;
use Illuminate\Console\Command;

class SendNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ws:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run news job';

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
        dispatch(new SendNewsJob());
    }
}
