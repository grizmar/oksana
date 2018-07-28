<?php

namespace App\Http\Controllers;

use Grizmar\Api\Controllers\BaseController;

class TestController extends BaseController
{
    public function show()
    {
        $this->response->addParam('CustomerData.Test', '1');

        return \response()->rest($this->response);
    }

    public function index()
    {
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
