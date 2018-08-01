<?php

namespace App\Rest\Providers;

use Illuminate\Support\ServiceProvider;
use Grizmar\Api\Messages\Keeper;
use App\Rest\Errors\ErrorCollection;

class RestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Keeper::load(new ErrorCollection());
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
