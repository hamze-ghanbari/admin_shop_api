<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\ColorProductService;
use App\Http\Controllers\Api\V1\Services\GalleryProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColorProductRequest;
use App\Http\Requests\GalleryProductRequest;
use App\Http\Services\ImageService\ImageService;
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

        $imageAddress = $this->galleryProductService->uploadFile($request->input('image'));
        if (!$imageAddress) {
            return $this->serverError('خطا در آپلود تصویر');
        }

        $this->galleryProductService->addImageToProduct($imageAddress, $product->id);
        return $this->apiResponse(null);
    }

    public function destroy(ImageService $imageService, Product $product, GalleryProduct $galleryProduct)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-gallery-product']))
            return $this->forbiddenResponse();

        $galleryDelete = $this->galleryProductService->deleteImageProduct($galleryProduct->id);

        if($galleryDelete){
            $this->galleryProductService->deleteImage($galleryProduct->image);
        }

        return $this->apiResponse(null, hasError: !(bool)$galleryDelete);
    }

}
