<?php

declare(strict_types=1);

namespace App\Http\Controllers\Rest;

use App\Model\Product;
use Elantha\Api\Http\Exceptions\NotFoundException;
use App\Rest\Error\CodeRegistry;

class ProductController extends BaseRestController
{
    protected function initValidationRules(): array
    {
        // todo later
        return [

        ];
    }

    public function index()
    {
        $result = [];
        $products = Product::all();

        foreach ($products as $product) {
            $result[] = $this->convertToApi($product);
        }

        $this->output('products', $result);

        return \response()->rest($this->response);
    }

    public function show(int $id)
    {
        $product = Product::find($id);

        if (!$product) {
            throw NotFoundException::make(CodeRegistry::PRODUCT_NOT_FOUND, ['id' => $id]);
        }

        $data = $this->convertToApi($product);

        $this->response->setData($data);

        return \response()->rest($this->response);
    }

    protected function convertToApi(Product $product): array
    {
        return [
            'id'          => $product->getAttribute('id'),
            'name'        => $product->getAttribute('name'),
            'description' => $product->getAttribute('description'),
        ];
    }
}
