<?php
namespace App\Http\Controllers;

use App\Rest\Response\ContentInterface;
use Illuminate\Http\Request;

class BaseRestController extends Controller
{
    protected $response;
    protected $request;
    private $validationRules = [];

    final public function __construct(Request $request, ContentInterface $response)
    {
        $this->response = $response;
        $this->request = $request;

        $this->initializeValidationRules();
    }

    protected function addError($code, $message): self
    {
        $this->response->addError($code, $message);

        return $this;
    }

    protected function input($key)
    {
        return $this->request->input($key);
    }

    protected function hasErrors(): bool
    {
        return $this->response->hasErrors();
    }

    //TODO пример, в будущем удалить
    public function show()
    {
        return \response()->rest(['hello']);
    }

    //TODO пример, в будущем удалить
    public function index()
    {
        $this->setValidationRules(['name' => 'required']);
        $this->response->setStatusCode(201);
        $this->response->setData([
            'method' => 'index',
            'name' => $this->request->input('name'),
        ]);
        $this->response->addError('506', 'test');

        return \response()->rest($this->response);
    }

    protected function initializeValidationRules(): self
    {
        $this->validationRules = [
            'name' => 'required',
        ];

        return $this;
    }

    protected function setValidationRules(array $rules): self
    {
        $this->validationRules = array_merge($this->validationRules, $rules);

        return $this;
    }

    protected function appendValidationRule(string $key, string $rule): self
    {
        $currentRule = array_get($this->validationRules, $key, false);
        $newRule = ($currentRule)
            ? $currentRule . '|' . $rule
            : $rule;

        array_set($this->validationRules, $key, $newRule);

        return $this;
    }
}
