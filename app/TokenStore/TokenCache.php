<?php

namespace App\TokenStore;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use League\OAuth2\Client\Provider\GenericProvider;

class TokenCache
{
    public function storeTokens($accessToken, $user)
    {
        Storage::put('microsoft.json', json_encode([
            'microsoft.accessToken' => $accessToken->getToken(),
            'microsoft.refreshToken' => $accessToken->getRefreshToken(),
            'microsoft.tokenExpires' => $accessToken->getExpires(),
            'microsoft.userName' => $user->getDisplayName(),
            'microsoft.userEmail' => null !== $user->getMail() ? $user->getMail() : $user->getUserPrincipalName()
        ]));
        session([
            'microsoft.accessToken' => $accessToken->getToken(),
            'microsoft.refreshToken' => $accessToken->getRefreshToken(),
            'microsoft.tokenExpires' => $accessToken->getExpires(),
            'microsoft.userName' => $user->getDisplayName(),
            'microsoft.userEmail' => null !== $user->getMail() ? $user->getMail() : $user->getUserPrincipalName()
        ]);
        Artisan::call('queue:restart');
    }

    public function clearTokens()
    {
        Storage::delete('microsoft.json');
        session()->forget('microsoft.accessToken');
        session()->forget('microsoft.refreshToken');
        session()->forget('microsoft.tokenExpires');
        session()->forget('microsoft.userName');
        session()->forget('microsoft.userEmail');
        Artisan::call('queue:restart');
    }

    public function getAccessToken()
    {
        // Sprawdzenie czy token istnieje
        $storage = null;
        if (Storage::exists('microsoft.json')) {
            $storage = json_decode(Storage::get('microsoft.json'), true);
        }
        if (empty(session('microsoft.accessToken')) ||
            empty(session('microsoft.refreshToken')) ||
            empty(session('microsoft.tokenExpires'))) {
            if ($storage != null) {
                session($storage);
            } else {
                return '';
            }
        }
        // Sprawdzenie czy token jest aktualny
        // Pobieramy aktualny czas i wydłużamy go o 5 minut dla bezpieczeństwa
        $now = time() + 300;
        if (session('microsoft.tokenExpires') <= $now) {
            // Jeżeli token wygasł lub ma za chwilę wygasnąć pobieramy nowy wykorzystując refresh_token
            $oauthClient = new GenericProvider([
                'clientId' => env('OAUTH_APP_ID'),
                'clientSecret' => env('OAUTH_APP_PASSWORD'),
                'redirectUri' => env('OAUTH_REDIRECT_URI'),
                'urlAuthorize' => env('OAUTH_AUTHORITY') . env('OAUTH_AUTHORIZE_ENDPOINT'),
                'urlAccessToken' => env('OAUTH_AUTHORITY') . env('OAUTH_TOKEN_ENDPOINT'),
                'urlResourceOwnerDetails' => '',
                'scopes' => env('OAUTH_SCOPES')
            ]);
            try {
                $newToken = $oauthClient->getAccessToken('refresh_token', [
                    'refresh_token' => session('microsoft.refreshToken')
                ]);
                // Zapisujemy wartości zarówno do pliku json jak i do sesji
                $this->updateTokens($newToken);
                return $newToken->getToken();
            } catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                return '';
            }
        }
        // Jeżeli token jest wciąż aktualny to go zwracamy
        return session('microsoft.accessToken');
    }

    public function updateTokens($accessToken)
    {
        Storage::put('microsoft.json', json_encode([
            'accessToken' => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
            'tokenExpires' => $accessToken->getExpires(),
            'userName' => session('microsoft.userName'),
            'userEmail' => session('microsoft.userEmail')
        ]));
        session([
            'microsoft.accessToken' => $accessToken->getToken(),
            'microsoft.refreshToken' => $accessToken->getRefreshToken(),
            'microsoft.tokenExpires' => $accessToken->getExpires()
        ]);
        Artisan::call('queue:restart');
    }
}
