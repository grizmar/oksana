<?php

namespace App\Rest\Exceptions;

use App\Rest\Base\CodeRegistry as CR;

class InternalServerErrorException extends HttpException
{
    public static function getDefaultCode(): int
    {
        return CR::INTERNAL_SERVER_ERROR;
    }
}
