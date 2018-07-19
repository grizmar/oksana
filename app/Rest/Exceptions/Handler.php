<?php

namespace App\Rest\Exceptions;

use Illuminate\Http\Request;
use App\Rest\Base\CodeRegistry as CR;
use App\Rest\Response\ContentInterface;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Handler
{
    public static function resolve(Request $request, \Exception $e)
    {
        $response = resolve(ContentInterface::class);

        report($e); // log exception

        if ($e instanceof HttpException) {

            $response
                ->addError($e->getCode(), $e->getMessage())
                ->setStatusCode($e->getCode());

        } elseif ($e instanceof BaseRestException) {

            $response
                ->addError($e->getCode(), $e->getMessage())
                ->setStatusCode(HttpResponse::HTTP_OK);

        } else {
            $response
                ->addError(
                    HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                    HttpResponse::$statusTexts[HttpResponse::HTTP_INTERNAL_SERVER_ERROR]
                )
                ->setStatusCode(HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->rest($response);
    }
}
