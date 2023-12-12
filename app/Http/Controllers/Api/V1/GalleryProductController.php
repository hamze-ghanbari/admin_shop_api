<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\ColorProductService;
use App\Http\Controllers\Api\V1\Services\GalleryProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColorProductRequest;
use App\Http\Requests\GalleryProductRequest;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\ColorProduct;
use App\Models\GalleryProduct;
use App\Models\Product;
use App\Traits\Response\ApiResponse;
use App\Traits\Response\ValidationResponse;

class GalleryProductController extends Controller
{
    use ApiResponse, ValidationResponse;

    public function __construct(
        public GalleryProductService $galleryProductService,
        public PolicyService      $policyService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:gallery,5')->only('store');
    }

    public function store(GalleryProductRequest $request, Product $product)
    {
        if (!$this->policyService->authorize(['admin'], ['create-gallery-product']))
            return $this->forbiddenResponse();

        $this->galleryProductService->addImageToProduct($request, $product->id);
        return $this->apiResponse(null);
    }

    public function destroy(Product $product, GalleryProduct $colorProduct)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-gallery-product']))
            return $this->forbiddenResponse();

        $metaDelete = $this->galleryProductService->deleteImageProduct($colorProduct->id);

        return $this->apiResponse(null, hasError: !(bool)$metaDelete);
    }

}
