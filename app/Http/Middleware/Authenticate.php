<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            Session::Flash('status','fail');
            Session::Flash('icon','error');
            Session::Flash('title','Hak Akses Dibatasi !');
            Session::Flash('message','Mohon untuk login');

            return Route('user.landing-page');
        }
    }
}
