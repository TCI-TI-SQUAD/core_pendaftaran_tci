<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
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
        if(Auth::guard('admin')->check()){
            return $next($request);
        }else{
            return redirect()->route('admin.auth.login')->with([
                'status' => 'fail',
                'icon' => 'error',
                'title' => 'Hak Akses Dibatasi !',
                'message' => 'Mohon untul login terlebih dahulu',
            ]);
        }
    }
}
