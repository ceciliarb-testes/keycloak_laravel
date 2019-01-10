<?php namespace App\Extensions;

use KeycloakGuard\Token;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use App\User;

class KeycloakUserProvider implements UserProvider
{
    private $kc_url = 'http://keycloak.qa.pbh/auth/realms/teste_cecilia/protocol/openid-connect';
    private $user;

    public function __construct()
    {
        $authorization = "Authorization: Bearer ".Cookie::get('access_token');
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_HEADER, false);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_PROXY, '');
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        // curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl_handle, CURLOPT_URL, "$this->kc_url/userinfo");
        $result = \json_decode(curl_exec($curl_handle));
        $u = null;
        if(isset($result) && !isset($result->error)) {
            $u = new User();
            $u->id       = $result->sub;
            $u->username = $result->preferred_username;
            $u->email    = $result->email;
        }
        $this->user  = $u;
    }

    public function retrieveById($identifier)
    {
        return $this->user;
    }

    public function retrieveByToken($identifier, $token)
    {
        return $this->user;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // update via remember token not necessary
    }

    public function retrieveByCredentials(array $credentials)
    {
        return $this->user;
		// implementation upto user.
		// how he wants to implement -
		// let's try to assume that the credentials ['username', 'password'] given
        $user = $this->user;
        foreach ($credentials as $credentialKey => $credentialValue) {
            if (!Str::contains($credentialKey, 'password')) {
                $user->where($credentialKey, $credentialValue);
            }
        }
        return $user->first();
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $plain = $credentials['password'];
        return app('hash')->check($plain, $user->getAuthPassword());
    }
}
