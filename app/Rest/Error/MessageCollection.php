<?php

namespace App\Rest\Error;

use Elantha\Api\Messages\BaseCollection;

class MessageCollection extends BaseCollection
{
    public function init(): void
    {
        $this->addMessages([
            'default' => __('api.default'), // lang example
            CodeRegistry::PRODUCT_NOT_FOUND => 'Sorry, product not found: :id!',
        ]);
    }
}
