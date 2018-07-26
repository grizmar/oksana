<?php

namespace App\Rest\Exceptions;

use Illuminate\Http\Response;

class UnauthorizedException extends BaseRestException
{
    public function getStatusCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}
