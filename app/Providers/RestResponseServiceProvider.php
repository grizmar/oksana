<?php

namespace App\Providers;

use App\Rest\Response\ContentInterface;
use App\Rest\Response\JsonResponse;
use App\Rest\Response\XmlResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class RestResponseServiceProvider extends ServiceProvider
{
    public const CONTENT_TYPE_JSON = 'application/json';
    public const CONTENT_TYPE_XML = 'application/xml';

    /**
     * Bootstrap the application services.
     *
     * @param Request $request
     * @return void
     */
    public function boot(Request $request): void
    {

        $this->bindResponse($request);

        Response::macro('rest', function ($data, $status = false) {
            if($data instanceof ContentInterface){
                $response = $data;
            }
            else{
                $response = resolve(ContentInterface::class);
                $response->setData($data);
            }

            if($status){
                $response->setStatusCode($status);
            }

            return $response->getAnswer();
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

    private function bindResponse(Request $request): void
    {
        $contentType = $request->header('Content-type') ?: self::CONTENT_TYPE_JSON;

        switch($contentType) {
            case self::CONTENT_TYPE_JSON:
                $responseClass = JsonResponse::class;
                break;
            case self::CONTENT_TYPE_XML:
                $responseClass = XmlResponse::class;
                break;
            default:
                $responseClass = JsonResponse::class;
        }

        $this->app->bind(ContentInterface::class, $responseClass);
    }
}
