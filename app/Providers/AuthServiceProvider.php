<?php

namespace App\Providers;

use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('mirror-sn', function ($request) {
            $serial = $request->header('Authorization', '');
            if (Str::startsWith($serial, 'SN ')) {
                $serial = Str::substr($serial, 3);
            }
            if ($serial != "") {
                return User::whereHas('mirrors', function ($q) use ($serial) {
                    $q->where('serial', $serial);
                })->first();
            }

            return null;
        });
    }
}
