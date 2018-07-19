<?php

namespace App\Rest\Base;

use App\Rest\Base\CodeRegistry as CR;

class ErrorCollection
{
    public static function getMap()
    {
        // TODO: move to lang
        return [
            CR::BAD_REQUEST           => 'Bad request',
            CR::UNAUTHORIZED          => 'Unauthorized',
            CR::FORBIDDEN             => 'Forbidden',
            CR::NOT_FOUND             => 'Not found',
            CR::METHOD_NOT_ALLOWED    => 'Method not allowed',
            CR::INTERNAL_SERVER_ERROR => 'Internal server error',
            CR::VALIDATION_ERROR      => __('api.validation_error'), // lang example
        ];
    }

    public static function getDefaultCode()
    {
        return CR::INTERNAL_SERVER_ERROR;
    }

    public static function getMessageByCode(int $code)
    {
        $message = self::getDirectMessage($code);

        if (!$message) {
            $message = self::getDirectMessage(self::getDefaultCode());
        }

        return $message;
    }

    private static function getDirectMessage(int $code)
    {
        return array_get(self::getMap(), $code, false);
    }
}
