<?php

namespace App\Rest\Exceptions;

use App\Rest\Base\CodeRegistry as CR;

class ForbiddenException extends HttpException
{
    public static function getDefaultCode(): int
    {
        return CR::UNAUTHORIZED;
    }
}
