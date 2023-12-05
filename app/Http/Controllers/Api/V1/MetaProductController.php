<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\MetaProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MetaProductRequest;
use App\Http\Resources\MetaProductCollection;
use App\Http\Resources\MetaProductResource;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\MetaProduct;
use App\Models\Product;
use App\Traits\Response\ApiResponse;
use App\Traits\Response\ValidationResponse;

class MetaProductController extends Controller
{
    use ApiResponse, ValidationResponse;

    public function __construct(
        public MetaProductService $metaProductService,
        public PolicyService      $policyService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:meta,5')->only('store', 'update', 'changeStatus');
    }

    public function index(Product $product)
    {
        if (!$this->policyService->authorize(['admin'], ['read-meta-product']))
            return $this->forbiddenResponse();

        return new MetaProductCollection($this->metaProductService->getAllMetaProducts($product));
    }

    public function show(Product $product, MetaProduct $metaProduct)
    {
        if (!$this->policyService->authorize(['admin'], ['read-meta-product']))
            return $this->forbiddenResponse();

        return $this->apiResponse(new MetaProductResource($metaProduct));
    }

    public function store(MetaProductRequest $request, Product $product)
    {
        if (!$this->policyService->authorize(['admin'], ['create-meta-product']))
            return $this->forbiddenResponse();

        $this->metaProductService->addMetaToProduct($request, $product->id);
        return $this->apiResponse(null);
    }

    public function update(MetaProductRequest $request, Product $product, MetaProduct $metaProduct)
    {
        if (!$this->policyService->authorize(['admin'], ['update-meta-product']))
            return $this->forbiddenResponse();

        $this->metaProductService->updateMetaProduct($request, $product->id, $metaProduct->id);
        return $this->apiResponse(null);

    }

    public function destroy(Product $product, MetaProduct $metaProduct)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-meta-product']))
            return $this->forbiddenResponse();

        $metaDelete = $this->metaProductService->deleteMetaProduct($metaProduct->id);

        return $this->apiResponse(null, hasError: (bool)$metaDelete);
    }

}
