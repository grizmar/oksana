<?php

namespace App\Rest\Exceptions;


class EmptyException extends BaseRestException
{
    public function getStatusCode(): int
    {
        return 0;
    }
}
