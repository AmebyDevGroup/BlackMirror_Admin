<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;

class SendUserFeatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ws:users-features {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send features information per user';

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
        $users = User::whereNotNull('email_verified_at')->get();
        $users_count = $users->count();
        $this->comment('Liczba użytkowników: '.$users_count);
        foreach($users as $key => $user) {
            $lp = $key+1;
            $this->info("Start {$lp}/{$users_count}");
            $features_configs = $user->featuresConfiguration()->where('active', 1)->get();
            foreach($features_configs as $feature_config) {
                $feature = $feature_config->feature;
                $this->line("-- Feature {$feature->slug}");
//                $schedule->job($feature->getJob($feature_config));
                dispatch($feature->getJob($feature_config));
            }
        }
    }
}
