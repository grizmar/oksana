<?php

namespace App\Providers;

use App\Rest\Response\ContentInterface;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class RestResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ContentInterface::class, \App\Rest\Response\Response::class);

        Response::macro('rest', function ($data, $status = HttpResponse::HTTP_OK) {
            if($data instanceof ContentInterface){
                $response = $data;
            }
            else{
                $response = resolve(ContentInterface::class);
                $response
                    ->setData($data)
                    ->setStatusCode($status);
            }

            return Response::json($response, $response->getStatusCode());
        });
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
