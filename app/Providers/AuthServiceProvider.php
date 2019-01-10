<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Extensions\KeycloakUserProvider;
use Illuminate\Support\Facades\Auth;
use KeycloakGuard\KeycloakGuard;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //definindo o driver de users do keycloak
        Auth::provider('kc_users', function($app, array $config) {
            return new KeycloakUserProvider();
        });
    }
}
