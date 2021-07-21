<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\PengaturanSocialMedia;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        // $social_medias = PengaturanSocialMedia::all();
        // View::share('social_medias',$social_medias);

        Schema::defaultStringLength(191);
    }
}