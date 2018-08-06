<?php

namespace App\Rest\Errors;

use Grizmar\Api\Messages\BaseCollection;

class ErrorCollection extends BaseCollection
{
    public function init()
    {
        $this->addMessages([
            'default' => __('api.default'), // lang example
            CodeRegistry::USER_NOT_FOUND => 'User not found',
        ]);
    }
}
