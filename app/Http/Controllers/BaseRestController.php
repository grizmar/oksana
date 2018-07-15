<?php
namespace App\Http\Controllers;

use App\Rest\Response\ContentInterface;

class BaseRestController extends Controller
{
    protected $response;

    public function __construct(ContentInterface $response)
    {
        $this->response = $response;
    }

    protected function addError($code, $message): self
    {
        $this->response->addError($code, $message);

        return $this;
    }

    protected function isSetErrors(): bool
    {
        return $this->response->isSetErrors();
    }

    //TODO пример, в будущем удалить
    public function show()
    {
        return \response()->rest(['hello']);
    }

    //TODO пример, в будущем удалить
    public function index()
    {
        $this->response->setStatusCode(201);
        $this->response->setData(['method' => 'index']);
        $this->response->addError('506', 'test');

        return \response()->rest($this->response);
    }
}
