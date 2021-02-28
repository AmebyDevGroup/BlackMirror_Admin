<?php

namespace App\Console;

use App\Console\Commands\SendData;
use App\Console\Commands\RedisSubscribe;
use GuzzleHttp\Client;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendData::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $cn_data = config('broadcasting.connections.' . config('broadcasting.default'));
        $api_url = "https://ws.myblackmirror.pl/apps/{$cn_data['app_id']}/channels?auth_key={$cn_data['key']}";
        $client = new Client();
        $response = $client->request('GET', $api_url);
        $data = json_decode($response->getBody()->getContents());
        $mirrors_sn = array_map(function ($value) {
            $channel_data = explode('.', $value);
            if (isset($channel_data[1])) {
                return $channel_data[1];
            }
        }, array_keys((array)$data->channels));
        if (count($mirrors_sn)) {
            // Tasks
//        $schedule->command(SendDataToMirrors::class, [$mirrors_sn, '--id' => 1])->cron('* * * * *');
            // Calendar
//        $schedule->command(SendDataToMirrors::class, [$mirrors_sn, '--id' => 2])->cron('*/15 * * * *');
            // News
            $schedule->command(SendData::class, [$mirrors_sn, '--id' => 3])->cron('0 */3 * * *');
            // Weather
            $schedule->command(SendData::class, [$mirrors_sn, '--id' => 4])->cron('10 * * * *');
            // Air
            $schedule->command(SendData::class, [$mirrors_sn, '--id' => 5])->cron('20 * * * *');
            // Covid
            $schedule->command(SendData::class, [$mirrors_sn, '--id' => 6])->cron('40 */3 * * *');
            // Sensors
            $schedule->command(SendData::class, [$mirrors_sn, '--id' => 9])->cron('*/15 * * * *');
        }

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
