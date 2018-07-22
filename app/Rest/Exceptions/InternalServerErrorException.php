<?php

namespace App\Rest\Exceptions;

use App\Rest\Base\CodeRegistry;

class InternalServerErrorException extends HttpException
{
    public static function getDefaultCode(): int
    {
        return CodeRegistry::INTERNAL_SERVER_ERROR;
    }
}
