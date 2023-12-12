<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Http\Requests\ColorProductRequest;
use App\Http\Requests\GalleryProductRequest;
use App\Http\Requests\MetaProductRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Models\Product;
use App\Repository\Contracts\ColorProductRepositoryInterface;
use App\Repository\Contracts\GalleryProductRepositoryInterface;
use App\Repository\Contracts\MetaProductRepositoryInterface;

class GalleryProductService
{

    public function __construct(
        public GalleryProductRepositoryInterface $galleryProductRepository,
        public CacheApiService                $cacheApiService
    )
    {
    }

    public function addImageToProduct(GalleryProductRequest $request, $productId)
    {
        $this->galleryProductRepository->create($request->fields(attributes: [
            'product_id' => $productId
        ]));
    }

    public function deleteImageProduct($colorId)
    {
        return $this->galleryProductRepository->delete($colorId);
    }

}
