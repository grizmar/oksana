<?php

namespace App\Rest\Exceptions;

use App\Rest\Base\CodeRegistry;

class ForbiddenException extends HttpException
{
    public static function getDefaultCode(): int
    {
        return CodeRegistry::FORBIDDEN;
    }
}
