<?php

namespace App\Http\Controllers\Api\V1\Product\Brand;

use App\Http\Requests\BrandRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Http\Services\ImageService\ImageService;
use App\Http\Services\UploadService\Algoritms\Base64FIle;
use App\Http\Services\UploadService\UploadService;
use App\Models\Brand;
use App\Repository\Contracts\BrandRepositoryInterface;

class BrandService
{

    public function __construct(
        public ImageService                $imageService,
        public BrandRepositoryInterface $brandRepository,
        public CacheApiService $cacheApiService
    )
    {
    }

    public function getAllBrands()
    {
        if($this->cacheApiService->useCache('brands')){
            return $this->cacheApiService->cacheApi('brands', $this->brandRepository->paginate());
        }
        return $this->brandRepository->paginate();
    }

    public function searchBrand($value){
        return $this->brandRepository->getBrandSearch($value);
    }

    public function categoryExists(string $name)
    {
        return $this->brandRepository->getBrandWithTrashed($name);
    }

    public function createBrand(BrandRequest $request, $image)
    {
        $this->brandRepository->create($request->fields(attributes: [
            'slug' => $request->fields()['name'],
            'image' => $image
        ]));
    }

    public function brandExists(string $name){
        return $this->brandRepository->getBrandWithTrashed($name);
    }

    public function updateBrand(BrandRequest $request, $brandId, $imageUrl)
    {
        return $this->brandRepository->update($request->fields(attributes: [
            'slug' => $request->fields()['name'],
            'image' => $imageUrl
        ]), $brandId);
    }

    public function updateBrandStatus(Brand $brand, $status)
    {
        return $this->brandRepository->update([
            'status' => (bool)$status
        ], $brand->id);
    }

    public function deleteBrand($id)
    {
        return $this->brandRepository->delete($id);
    }

    public function uploadImage($image)
    {
        $this->imageService->setExclusiveDirectory('uploads' . DIRECTORY_SEPARATOR . 'brands');

        $file = new Base64File($this->imageService, $image);
        $upload = new UploadService($file);
        $imageAddress = $upload->upload();

        return $imageAddress ?? false;
    }

}
