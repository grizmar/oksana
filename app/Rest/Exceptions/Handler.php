<?php

namespace App\Rest\Exceptions;

use App\Rest\Base\CodeRegistry as CR;
use App\Rest\Response\ContentInterface;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Handler
{
    public static function resolve(\Exception $e)
    {
        report($e); // log exception

        if ($e instanceof BaseRestException) {

            $response = $e->getResponse();

            if (empty($response)) {
                $response = resolve(ContentInterface::class);
            }

            if (!$e instanceof EmptyException) {
                $response->addError($e->getCode(), $e->getMessage());
            }

            if ($e instanceof HttpException) {
                $response->setStatusCode($e->getCode());
            }

        } else {
            $response = self::getInternalErrorResponse();
        }

        return response()->rest($response);
    }

    private static function getInternalErrorResponse(): ContentInterface
    {
        $response = resolve(ContentInterface::class);

        $response
            ->addError(
                HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                HttpResponse::$statusTexts[HttpResponse::HTTP_INTERNAL_SERVER_ERROR]
            )
            ->setStatusCode(HttpResponse::HTTP_INTERNAL_SERVER_ERROR);

        return $response;
    }
}
