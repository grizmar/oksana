<?php

namespace App\Exceptions;

use App\Rest\Response\ContentInterface;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Psy\Exception\FatalErrorException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //TODO нужно либо сделать возфможность переопределять Handler либо вынести обработку ошибок api в отдельный
        // класс

        $response = resolve(ContentInterface::class);
        if ($exception instanceof NotFoundException) {
            $response
                ->addError($exception->getCode(), $exception->getMessage())
                ->setStatusCode(HttpResponse::HTTP_NOT_FOUND);

            return response()->rest($response);
        } elseif($exception instanceof \Exception) {
            $response
                ->addError(HttpResponse::HTTP_INTERNAL_SERVER_ERROR, HttpResponse::$statusTexts[HttpResponse::HTTP_INTERNAL_SERVER_ERROR])
                ->setStatusCode(HttpResponse::HTTP_INTERNAL_SERVER_ERROR);

            return response()->rest($response);
        }


        return parent::render($request, $exception);
    }
}
