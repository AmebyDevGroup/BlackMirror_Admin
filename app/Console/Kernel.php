<?php

namespace App\Console;

use App\Console\Commands\SendAir;
use App\Console\Commands\SendCalendar;
use App\Console\Commands\SendNews;
use App\Console\Commands\SendTasks;
use App\Console\Commands\SendUserFeatures;
use App\Console\Commands\SendWeather;
use App\Console\Commands\SendCovid;

use App\Console\Commands\RedisSubscribe;

use App\MirrorConfig;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendTimeJob;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendTasks::class,
        SendCalendar::class,
        SendNews::class,
        SendWeather::class,
        SendAir::class,
        SendCovid::class,
        SendUserFeatures::class,
        RedisSubscribe::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $users = User::whereNotNull('email_verified_at')->get();
        // foreach($users as $key => $user) {
        //     $features_configs = $user->featuresConfiguration()->where('active', 1)->get();
        //     foreach($features_configs as $feature_config) {
        //         $feature = $feature_config->feature;
        //         $job = $feature->getJob($feature_config);
        //         $schedule->job($job)->cron($feature->crontab);
        //     }
        // }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
