<?php

namespace App\Rest\Exceptions;

use App\Rest\Base\ErrorCollection;
use App\Rest\Response\ContentInterface;

abstract class BaseRestException extends \Exception
{
    private $response;

    public function create(int $code = 0, ContentInterface $response = null): self
    {
        $this->setResponse($response);

        // TODO: improve
        $message = ErrorCollection::getMessageByCode($code);

        return new static($message, $code);
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
