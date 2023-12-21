<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Requests\MetaProductRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\Product;
use App\Repository\Contracts\MetaProductRepositoryInterface;

class MetaProductService
{

    public function __construct(
        public MetaProductRepositoryInterface $metaProductRepository,
        public CacheApiService                $cacheApiService
    )
    {
    }

    public function getAllMetaProducts(Product $product)
    {
        if ($this->cacheApiService->useCache('metaProducts')) {
            return $this->cacheApiService->cacheApi('metaProducts', $product->metas()->paginate());
        }
        return $product->metas()->paginate();
    }

    public function addMetaToProduct(MetaProductRequest $request, $productId)
    {
        $values = $request->fields();
        foreach ($values as $key => $val) {
            $values[$key]['product_id'] = $productId;
        }
        $this->metaProductRepository->insert($values);
    }

    public function updateMetaProduct(MetaProductRequest $request, $productId, $metaProductId)
    {
        return $this->metaProductRepository->update($request->fields(attributes: [
            'product_id' => $productId
        ]), $metaProductId);
    }

    public function deleteMetaProduct($metaProductId)
    {
        return $this->metaProductRepository->delete($metaProductId);
    }

    public function multiDeleteMetaProduct(...$metaProductIds)
    {
        return $this->metaProductRepository->delete($metaProductIds);
    }

}
