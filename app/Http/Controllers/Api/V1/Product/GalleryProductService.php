<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Services\CacheApiService\CacheApiService;
use App\Http\Services\ImageService\ImageService;
use App\Http\Services\UploadService\Algoritms\Base64File;
use App\Http\Services\UploadService\UploadService;
use App\Repository\Contracts\GalleryProductRepositoryInterface;

class GalleryProductService
{

    public function __construct(
        public GalleryProductRepositoryInterface $galleryProductRepository,
        public CacheApiService                $cacheApiService,
        public ImageService $imageService
    )
    {
    }

    public function addImageToProduct($imageAddress, $productId)
    {
        $this->galleryProductRepository->create([
            'image' => $imageAddress,
            'product_id' => $productId
        ]);
    }

    public function deleteImageProduct($imageId)
    {
        return $this->galleryProductRepository->delete($imageId);
    }

    public function deleteImage($imagePath)
    {
        if(isset($imagePath)) {
            foreach ($imagePath['indexArray'] as $path) {
                $this->imageService->deleteIndex($path);
            }
        }
    }

    public function uploadFile($image)
    {
        $this->imageService->setExclusiveDirectory('uploads' . DIRECTORY_SEPARATOR . 'products');

        $file = new Base64File($this->imageService, $image);
        $upload = new UploadService($file);
        $imageAddress = $upload->uploadIndexFile();

        return $imageAddress ?? false;
    }

}
