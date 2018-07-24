<?php

namespace App\Rest\Exceptions;

use App\Rest\Messages\Manager;
use App\Rest\Response\ContentInterface;

abstract class BaseRestException extends \Exception
{
    private $response;

    public static function create($code = 0, array $context = [], ContentInterface $response = null): self
    {
        $message = Manager::getMessage($code, $context);

        // TODO: log error

        $instance = (new static($message, $code));

        if (!empty($response)) {
            $instance->setResponse($response);
        }

        return $instance;
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

    abstract public function getStatusCode(): int;
}
