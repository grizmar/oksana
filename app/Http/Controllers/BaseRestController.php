<?php
namespace App\Http\Controllers;

use App\Rest\Response\ContentInterface;
use App\Rest\Validators\RequestValidator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BaseRestController extends Controller
{
    use RequestValidator;

    protected $response;
    protected $request;

    final public function __construct(Request $request, ContentInterface $response)
    {
        $this->response = $response;
        $this->request = $request;
        $this->initializeValidationRules();

        //TODO перенести в обработчик ошибок
        try{
            $this->validate($request, $this->validationRules);
        } catch(ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();

            foreach($errors as $fieldName => $fieldMessages)
            {
                $this->response->setValidationErrors($fieldName, $fieldMessages);
            }

            $this->response->setStatusCode($e->status);
        }
    }

    final protected function hasErrors(): bool
    {
        return $this->response->isValid();
    }

    final protected function input($key)
    {
        return $this->request->input($key);
    }

    //TODO базовая реализация, сюда будут добавляться только основные правила валидации
    protected function initializeValidationRules(): self
    {
        $this->validationRules = [
            'name' => 'required|max:3|email'
        ];

        return $this;
    }

    //TODO пример, в будущем удалить
    public function show()
    {
        return \response()->rest(['hello']);
    }

    //TODO пример, в будущем удалить
    public function index()
    {
        $request->toArray();
        //$this->setValidationRules(['name' => 'required']);
        $this->response->setStatusCode(201);
        $this->response->setData([
            'storage_path' => storage_path('Rest/hello/file.log'),
            'app_path' => app_path('Rest/hello/file.log'),
            'method' => 'index'
        ]);
        $this->response->addError('506', 'test');

        return \response()->rest($this->response);
    }

    //TODO пример
    public function update()
    {
        //$this->response->setStatusCode(201);
        $this->response->setData([
            'storage_path' => storage_path('Rest/hello/file.log'),
            'app_path' => app_path('Rest/hello/file.log'),
            'method' => 'index'
        ]);

        return \response()->rest($this->response);
    }
}
