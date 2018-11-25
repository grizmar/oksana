<?php

namespace App\Http\Controllers;

use Grizmar\Api\Controllers\BaseController;
use Grizmar\Api\Http\Exceptions\UnauthorizedException;

class TestController extends BaseController
{
    protected function initValidationRules(): array
    {
        return [
            'index' => [
                'name' => 'required',
            ],
        ];
    }

    public function show()
    {
        return \response()->rest($this->response);
    }

    public function index()
    {
        $this->output('level1.level2.info', 'I\'m data!');

        throw UnauthorizedException::make(1000, ['name' => $this->input('name', 'Unknown')])
            ->setResponse($this->response);

        return \response()->rest($this->response);
    }
}
