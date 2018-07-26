<?php

namespace App\Rest\Exceptions;

use Illuminate\Http\Request;
use App\Rest\Response\ContentInterface;
use Symfony\Component\HttpFoundation\Response;

class Handler
{
    public static function render(Request $request, \Exception $e)
    {
        report($e); // log exception

        if ($e instanceof BaseRestException) {

            $response = $e->getResponse();

            if (!($e instanceof EmptyException)) {
                $response
                    ->addError($e->getCode(), $e->getMessage())
                    ->setStatusCode($e->getStatusCode());
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
                Response::HTTP_INTERNAL_SERVER_ERROR,
                Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]
            )
            ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

        return $response;
    }
}
