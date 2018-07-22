<?php

namespace App\Rest\Exceptions;

use Illuminate\Http\Response;

class InternalServerErrorException extends BaseRestException
{
    public function getStatusCode(): int
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
