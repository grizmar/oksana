<?php
namespace App\Rest\Response;

interface ContentInterface
{
    public function getData(): array;

    public function setData(array $data);

    public function appendData(array $data);

    public function setStatusCode(int $code);

    public function getStatusCode(): int;

    public function hasErrors(): bool;

    public function getErrors(): array;

    public function addError(int $code, string $message);

    public function getAnswer();

    public function getMap(): array;
}