<?php
namespace App\Rest\Response;

use App\Providers\RestResponseServiceProvider;

class XmlResponse extends BaseResponse
{

    public function getAnswer()
    {
        return \response($this->getMap(), $this->getStatusCode())
            ->header('Content-Type', RestResponseServiceProvider::CONTENT_TYPE_XML);
    }
}