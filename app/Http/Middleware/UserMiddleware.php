<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        try{
            $notifications = Auth::user()->unreadNotifications->count() > 99 ? +99 : Auth::user()->unreadNotifications->count();
            $notifications = $notifications <= 0 ? null : $notifications;
            View::share('notifications',$notifications);

        }catch(ModelNotFoundException $err){
            View::share('notifications',null);
        }

        return $next($request);
    }
}
