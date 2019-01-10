<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
use KeycloakGuard\Token;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\User;
use KeycloakGuard\Exceptions\TokenException;

class OpenIdController extends Controller
{
    private $kc_url = 'http://keycloak.qa.pbh/auth/realms/teste_cecilia/protocol/openid-connect';

    public function token(Request $request)
    {
        if(!isset($request->code)) {
            $qs = http_build_query([
                'response_type' => 'code',
                'scope'         => 'openid',
                'client_id'     => 'teste1',
                'redirect_uri'  => 'http://localhost:8000/token',
                'state'         => str_random(6)
                ]);
                return redirect("$this->kc_url/auth?$qs");

        } else {
            $cpost = http_build_query([
                'grant_type'    => 'authorization_code',
                'scope'         => 'openid',
                'code'          => $request->code,
                'redirect_uri'  => 'http://localhost:8000/token',
                'client_id'     => 'teste1',
                'client_secret' => '65b0d71d-0936-4f3b-a161-9540578ae917'
            ]);

            $curl_handle=curl_init();

            curl_setopt($curl_handle, CURLOPT_HEADER, false);
            curl_setopt($curl_handle, CURLOPT_POST, true);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $cpost);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_PROXY, '');
            // curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl_handle, CURLOPT_URL, "$this->kc_url/token");

            $result = \json_decode(curl_exec($curl_handle));
            if(isset($result->id_token)) {
                $id = Token::decode($result->id_token, config('keycloak.realm_public_key'));
                $us = User::where('username', $id->preferred_username)->first();
                if(!$us) {
                    $us = new User();
                    $us->username = $id->preferred_username;
                    $us->email    = $id->email;
                }
                if(isset($result->access_token)) {
                    $us->token = $result->access_token;
                    // session(['access_token' => $result->access_token]);
                    // session(['refresh_token'=> $result->refresh_token]);
                    // session(['id_token'     => $result->id_token]);
                    // session(['client_id'    => 'teste1']);
                    Cookie::queue('access_token' , $result->access_token , 100, null, null, false, true);
                    Cookie::queue('refresh_token', $result->refresh_token, 100, null, null, false, true);
                    Cookie::queue('id_token'     , $result->id_token     , 100, null, null, false, true);
                    Cookie::queue('client_id'    , 'teste1'              , 100, null, null, false, true);
                }
                $us->save();
            }
            $info = curl_getinfo($curl_handle);
            $error = curl_error($curl_handle);
            curl_close($curl_handle);
            return redirect("/");

        }
    }

    public function login()
    {
        try {
            if(!Auth::guard('api')->check()) {
                return redirect("/token");
            } else {
                $u = Auth::guard('api')->user();
                return "logado como ".$u->email."!";
            }
        } catch(TokenException $e) {
            return redirect("/token");
        }
    }

    public function logout()
    {
        $qs = http_build_query([
            'post_logout_redirect_uri'  => 'http://localhost:8000/',
            'client_id'                 => session()->get('client_id'),
            'client_secret'             => '65b0d71d-0936-4f3b-a161-9540578ae917',
            'refresh_token'             => session()->get('refresh_token')
        ]);
        // session()->forget('id_token');
        // session()->forget('access_token');
        // session()->forget('refresh_token');
        // session()->forget('client_id');
        Cookie::queue(Cookie::forget('access_token'));
        Cookie::queue(Cookie::forget('refresh_token'));
        Cookie::queue(Cookie::forget('id_token'));
        Cookie::queue(Cookie::forget('client_id'));
        return redirect("$this->kc_url/logout?$qs");
    }
}
