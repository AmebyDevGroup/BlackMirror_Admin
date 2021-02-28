<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\TokenStore\TokenCache;
use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\GenericProvider;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\User;

class MicrosoftAuthController extends Controller
{
    public function signin()
    {
        $oauthClient = new GenericProvider([
            'clientId' => env('OAUTH_APP_ID'),
            'clientSecret' => env('OAUTH_APP_PASSWORD'),
            'redirectUri' => env('OAUTH_REDIRECT_URI'),
            'urlAuthorize' => env('OAUTH_AUTHORITY') . env('OAUTH_AUTHORIZE_ENDPOINT'),
            'urlAccessToken' => env('OAUTH_AUTHORITY') . env('OAUTH_TOKEN_ENDPOINT'),
            'urlResourceOwnerDetails' => '',
            'scopes' => env('OAUTH_SCOPES')
        ]);
        $authUrl = $oauthClient->getAuthorizationUrl();
        session(['oauthState' => $oauthClient->getState()]);

        return redirect()->away($authUrl);
    }

    public function callback(Request $request)
    {
        $expectedState = session('oauthState');
        $request->session()->forget('oauthState');
        $providedState = $request->query('state');

        if (!isset($expectedState)) {
            return redirect()->route('admin.getExternalAccounts');
        }

        if (!isset($providedState) || $expectedState != $providedState) {
            return redirect()->route('admin.getExternalAccounts')
                ->with('error', 'Invalid auth state')
                ->with('errorDetail', 'The provided auth state did not match the expected value');
        }

        $authCode = $request->query('code');
        if (isset($authCode)) {
            // Initialize the OAuth client
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
                $accessToken = $oauthClient->getAccessToken('authorization_code', [
                    'code' => $authCode
                ]);
                $graph = new Graph();
                $graph->setAccessToken($accessToken->getToken());
                $user = $graph->createRequest('GET', '/me')
                    ->setReturnType(User::class)
                    ->execute();

                $tokenCache = new TokenCache();
                $tokenCache->storeTokens($accessToken, $user);

                return redirect()->route('admin.getExternalAccounts');
            } catch (\Exception $e) {
                return redirect()->route('admin.getExternalAccounts')
                    ->with('error', 'Error requesting access token')
                    ->with('errorDetail', $e->getMessage());
            }
        }

        return redirect()->route('admin.getExternalAccounts')
            ->with('error', $request->query('error'))
            ->with('errorDetail', $request->query('error_description'));
    }

    public function signout()
    {
        $tokenCache = new TokenCache();
        $tokenCache->clearTokens();
        return redirect()->route('admin.getExternalAccounts');
    }
}
