<?php

namespace App\Broadcasting;

use Illuminate\Support\Str;
use App\Jobs;
use App\MirrorConfig;
use App\Events\Message;
use App\Feature;
use Log;

class MirrorChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @return array|bool
     */
    public function join($user)
    {
        broadcast(new Message('config', $user->getConfig(), $this->normalizeChannelName(request()->channel_name)));
        $features_configs = $user->featuresConfiguration()->where('active', 1)->get();
        foreach($features_configs as $feature_config) {
            $feature = $feature_config->feature;
            dispatch($feature->getJob($feature_config, $this->normalizeChannelName(request()->channel_name)));
        }
        return [
            'user_id' => $user->id,
            'user_name' => $user->name
        ];
    }

    public function normalizeChannelName($channel)
    {
        foreach (['private-encrypted-', 'private-', 'presence-'] as $prefix) {
            if (Str::startsWith($channel, $prefix)) {
                return Str::replaceFirst($prefix, '', $channel);
            }
        }

        return $channel;
    }
}
