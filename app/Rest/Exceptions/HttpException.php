<?php

namespace App\Rest\Exceptions;


class HttpException extends BaseRestException
{
    protected function prepareCode(int &$code): void
    {
        $code = static::getDefaultCode();
    }
}
