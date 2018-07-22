<?php

namespace App\Rest\Exceptions;

use App\Rest\Base\CodeRegistry as CR;
use App\Rest\Base\ErrorCollection;
use App\Rest\Response\ContentInterface;

class BaseRestException extends \Exception
{
    private $response = null;

    public function __construct(int $code = 0, string $message = "", \Throwable $previous = null)
    {
        $this->prepareCode($code);

        // TODO: log incoming $message before map replace

        $message = ErrorCollection::getMessageByCode($code);

        parent::__construct($message, $code, $previous);
    }

    public function addResponse(ContentInterface $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public static function getDefaultCode(): int
    {
        return CR::INTERNAL_SERVER_ERROR;
    }

    protected function prepareCode(int &$code): void
    {
        if ($code <= 0) {
            $code = static::getDefaultCode();
        }
    }
}
