<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\ColorProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColorProductRequest;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\ColorProduct;
use App\Models\Product;
use App\Traits\Response\ApiResponse;
use App\Traits\Response\ValidationResponse;

class ColorProductController extends Controller
{
    use ApiResponse, ValidationResponse;

    public function __construct(
        public ColorProductService $colorProductService,
        public PolicyService      $policyService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:color,5')->only('store');
    }

    public function store(ColorProductRequest $request, Product $product)
    {
        if (!$this->policyService->authorize(['admin'], ['create-color-product']))
            return $this->forbiddenResponse();

        $this->colorProductService->addColorToProduct($request, $product->id);
        return $this->apiResponse(null);
    }

    public function destroy(Product $product, ColorProduct $colorProduct)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-color-product']))
            return $this->forbiddenResponse();

        $metaDelete = $this->colorProductService->deleteColorProduct($colorProduct->id);

        return $this->apiResponse(null, hasError: !(bool)$metaDelete);
    }

}
