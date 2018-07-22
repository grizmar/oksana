<?php

namespace App\Rest\Exceptions;

use App\Rest\Base\CodeRegistry;
use App\Rest\Base\ErrorCollection;
use App\Rest\Response\ContentInterface;

class BaseRestException extends \Exception
{
    private $response;

    public function create(int $code = 0, ContentInterface $response = null)
    {
        $this->prepareCode($code);

        $this->setResponse($response);

        $message = ErrorCollection::getMessageByCode($code);

        return new self($message, $code);
    }

    public function setResponse(ContentInterface $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getResponse(): ContentInterface
    {
        if (empty($this->response)) {
            $this->response = resolve(ContentInterface::class);
        }

        return $this->response;
    }

    public static function getDefaultCode(): int
    {
        return CodeRegistry::INTERNAL_SERVER_ERROR;
    }

    protected function prepareCode(int &$code): void
    {
        if ($code <= 0) {
            $code = static::getDefaultCode();
        }
    }
}
