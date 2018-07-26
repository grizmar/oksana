<?php

namespace App\Rest\Exceptions;

use Illuminate\Http\Response;

class NotFoundException extends BaseRestException
{
    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
