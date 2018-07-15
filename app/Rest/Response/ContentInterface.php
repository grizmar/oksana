<?php
namespace App\Rest\Response;

use JsonSerializable;

interface ContentInterface extends JsonSerializable
{
    public function getData(): array;

    public function setData(array $data): Response;

    public function appendData(array $data): Response;

    public function setStatusCode(int $code): Response;

    public function getStatusCode(): int;

    public function isSetErrors(): bool;

    public function getErrors(): array;

    public function addError(int $code, string $message): Response;
}