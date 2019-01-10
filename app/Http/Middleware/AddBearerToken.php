<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class AddBearerToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // $token = session('access_token');
        $token  = Cookie::get('access_token');
        if($token) {
            $request->headers->set('Authorization', 'Bearer '.$token);
        }
        return $next($request);
    }
}
