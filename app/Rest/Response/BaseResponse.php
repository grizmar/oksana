<?php
namespace App\Rest\Response;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

class BaseResponse implements ContentInterface
{
    protected $data = [];

    protected $errors = [];

    protected $status = HttpResponse::HTTP_OK;

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function appendData(array $data): self
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    public function addError(int $code, string $message): self
    {
        $this->errors[$code] = $message;

        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getStatusCode(): int
    {
        return $this->status;
    }

    public function setStatusCode(int $code): self
    {
        $this->status = $code;

        return $this;
    }

    public function getAnswer()
    {
        return \response($this->getMap(), $this->getStatusCode());
    }

    public function getMap(): array
    {
        return [
            'status' => $this->getStatusCode(),
            'errors' => $this->getErrors(),
            'data'   => $this->data,
        ];
    }
}