<?php


namespace App\Http\Controllers;


use App\Feature;
use App\Notifications\ContactNotification;
use App\Notifications\ContactSendNotification;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class AdminPanelController
{
    public function getConfigurationPage()
    {
        $features = Feature::with('config')->orderBy('ordering')->get();
        return view('panel.configuration', ['features' => $features]);
    }

    public function getExternalAccountsPage()
    {
        $microsoft = session('microsoft', null);
        $google = session('google', null);
        $facebook = session('facebook', null);
        $data = [
            'microsoft' => $microsoft,
            'google' => $google,
            'facebook' => $facebook
        ];
        return view('panel.external-accounts', $data);
    }

    public function getDevices()
    {
        $status = $this->getDevicesStatus();
        return view('panel.devices', ['devices' => auth()->user()->mirrors, 'status' => $status]);
    }

    public function getShowPage()
    {
        return view('panel.show');
    }

    public function getDevicesStatus()
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

        return auth()->user()->mirrors->pluck('', 'serial')->map(function ($value, $key) use ($mirrors_sn) {
            if (in_array($key, $mirrors_sn)) {
                return true;
            } else {
                return false;
            }
        });
    }

    public function getWebsocketsTestPage()
    {
        $features = Feature::whereHas('config', function ($q) {
            $q->where('active', 1);
        })->orderBy('ordering')->get();
        return view('panel.test-websockets', ['features' => $features]);
    }

    public function getHelpPage()
    {
        return view('panel.help');
    }

    public function getInfoPage()
    {
        return view('panel.info');
    }

    public function getChangelogPage()
    {
        $apps = [
            'Panel Administracyjny' => 'https://api.github.com/repos/AmebyDevGroup/BlackMirror_Admin/commits',
            'Aplikacja Mobilna' => 'https://api.github.com/repos/AmebyDevGroup/BlackMirror_Mobile/commits',
            'Aplikacja Kliencka' => 'https://api.github.com/repos/AmebyDevGroup/BlackMirror_Client/commits'
        ];
        $commits = Cache::remember('App::commits', 3600, function () use ($apps) {
            $commits = [];
            foreach ($apps as $app => $url) {
                $client = new Client();
                $response = $client->request('GET',
                    $url);
                $data = json_decode($response->getBody()->getContents());
                $commits[$app] = collect(array_slice($data, 0, 12))->pluck('commit');
            }
            return $commits;
        });

        return view('panel.changelog', ['commits' => $commits]);
    }

    public function getContactForm()
    {
        return view('panel.contact');
    }

    public function sendContactForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        Notification::route('mail', $request->email)
            ->notify(new ContactSendNotification());
        Notification::route('mail', 'kontakt@myblackmirror.pl')
            ->notify(new ContactNotification($request));

        return redirect()->back()->with(['flash.message' => 'Twoja wiadomość została wysłana']);
    }
}
