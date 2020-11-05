<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Socialite;
use Google_Client;
use Google_Service_Calendar;

class GoogleAuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')->scopes(['https://www.googleapis.com/auth/calendar.readonly'])
            ->with(["access_type" => "offline", "prompt" => "consent select_account"])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();
    }
}
