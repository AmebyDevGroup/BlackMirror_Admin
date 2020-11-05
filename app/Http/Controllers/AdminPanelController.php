<?php


namespace App\Http\Controllers;


use App\Feature;
use App\Notifications\ContactNotification;
use App\Notifications\ContactSendNotification;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

    public function getWebsocketsTestPage()
    {
        $features = Feature::whereHas('config', function ($q) {
            $q->where('active',1);
        })->orderBy('ordering')->get();
        return view('panel.test-websockets', ['features'=>$features]);
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
        $client = new Client();
        $response = $client->request('GET',
            'https://api.github.com/repos/KrzychuW/BlackMirror/commits');
        $data = json_decode($response->getBody()->getContents());
        $commits = collect(array_slice($data, 0, 12))->pluck('commit');
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
