<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

/**
 * This middleware needs to be abled in bootstrap/app.php
 */
class AuthenticateAccess
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

        // get all the string secrets in the env variable and save them into an array with explode
        $validSecrets = explode(',', env('ACCEPTED_SECRETS') );
        // dd($validSecrets);
        // we have access to the request so we can ask if the valid secret is in the $request param and if is equal to any in the array secrets
        if ( in_array($request->header('Authorization') , $validSecrets) ) {

            // if the secret in headers is in the validSecrets array from env then let this continue with the request
            return $next($request);
        }
        

        // if there is no valid secret in headers then abort and stop the request and throw an Unauthorized exception

        return abort(Response::HTTP_UNAUTHORIZED);
    }
}
