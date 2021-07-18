<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModelEncryptCast extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '\Helper\EncryptCast.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
