<?php

namespace App\Console\Commands;

use App\Jobs\SendCalendarJob;
use Illuminate\Console\Command;

class SendCalendar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ws:calendar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send calendar job';

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
        dispatch(new SendCalendarJob());
    }
}
