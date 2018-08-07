<?php

namespace App\Rest\Providers;

use Illuminate\Support\ServiceProvider;
use Grizmar\Api\Messages\KeeperInterface;
use App\Rest\Errors\ErrorCollection;

class RestServiceProvider extends ServiceProvider
{
    public function boot(KeeperInterface $keeper)
    {
        $keeper->load(new ErrorCollection());
    }

    public function register()
    {
        //
    }
}
