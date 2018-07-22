<?php
namespace App\Rest\Response;

class JsonResponse extends BaseResponse
{

    public function getAnswer()
    {
        return \response()->json($this->getMap(), $this->getStatusCode());
    }
}