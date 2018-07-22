<?php

namespace App\Rest\Exceptions;

use Illuminate\Http\Response;

class ForbiddenException extends BaseRestException
{
    public function getStatusCode(): int
    {
        return Response::HTTP_FORBIDDEN;
    }
}
