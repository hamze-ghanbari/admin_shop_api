<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Http\Requests\ColorProductRequest;
use App\Http\Requests\MetaProductRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\Product;
use App\Repository\Contracts\ColorProductRepositoryInterface;
use App\Repository\Contracts\MetaProductRepositoryInterface;

class ColorProductService
{

    public function __construct(
        public ColorProductRepositoryInterface $colorProductRepository,
        public CacheApiService                $cacheApiService
    )
    {
    }

    public function addColorToProduct(ColorProductRequest $request, $productId)
    {
        $this->colorProductRepository->create($request->fields(attributes: [
            'product_id' => $productId
        ]));
    }

    public function deleteColorProduct($colorId)
    {
        return $this->colorProductRepository->delete($colorId);
    }

}
