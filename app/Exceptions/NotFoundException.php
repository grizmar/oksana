<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response as HttpResponse;
use Throwable;

class NotFoundException extends Exception
{

    public function __construct(string $message = 'Not found', int $code = HttpResponse::HTTP_NOT_FOUND, Throwable
    $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
