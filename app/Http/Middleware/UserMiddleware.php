<?php

namespace App\Http\Middleware;
use Auth;

use Closure;

class UserMiddleware
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
        if(Auth::user()->hak_akses == 'ban'){
            return redirect()->route('user.landing-page')->with([
                'status' => 'fail',
                'icon' => 'error',
                'title' => 'Hak Akses Anda Dibatasi !',
                'message' => 'Saat ini anda tidak akan bisa mengakses sistem, mohon hubungi admin apabila diperlukan'
            ]);
        }
        return $next($request);
    }
}
