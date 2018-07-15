<?php
namespace App\Rest\Response;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Response implements ContentInterface
{
    private $data = [];

    private $errors = [];

    private $status = HttpResponse::HTTP_OK;

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): Response
    {
        $this->data = $data;

        return $this;
    }

    public function appendData(array $data): Response
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    public function addError(int $code, string $message): Response
    {
        $this->errors[$code] = $message;

        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isSetErrors(): bool
    {
        return (!empty($this->errors));
    }

    public function getStatusCode(): int
    {
        return $this->status;
    }

    public function setStatusCode(int $code): Response
    {
        $this->status = $code;

        return $this;
    }

    public function jsonSerialize()
    {
        phpinfo();die();
        $this->addError('hello', 'hello');

        return [
            'errors' => $this->getErrors(),
            'data' => $this->data,
            'status' => $this->getStatusCode(),
        ];
    }
}