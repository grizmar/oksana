<?php

namespace App\Rest\Errors;

use Elantha\Api\Messages\BaseCollection;

class ErrorCollection extends BaseCollection
{
    public function init(): void
    {
        $this->addMessages([
            'default' => __('api.default'), // lang example
            CodeRegistry::USER_NOT_FOUND => 'User not found: :name!',
        ]);
    }
}
