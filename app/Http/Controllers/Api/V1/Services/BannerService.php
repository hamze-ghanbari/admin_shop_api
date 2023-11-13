<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Enums\StatusEnum;
use App\Http\Requests\BannerRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Http\Services\ImageService\ImageService;
use App\Http\Services\UploadService\Algoritms\Base64FIle;
use App\Http\Services\UploadService\UploadService;
use App\Models\Banner;
use App\Repository\Contracts\BannerRepositoryInterface;

class BannerService
{

    public function __construct(
        public ImageService                $imageService,
        public BannerRepositoryInterface $bannerRepository,
        public CacheApiService $cacheApiService
    )
    {
    }

    public function getAllBanners()
    {
        if($this->cacheApiService->useCache('banners')){
            return $this->cacheApiService->cacheApi('banners', $this->bannerRepository->paginate());
        }
        return $this->bannerRepository->paginate();
    }

    public function getDisplayableBanners()
    {
        if($this->cacheApiService->useCache('banners')){
            return $this->cacheApiService->cacheApi('banners',  $this->bannerRepository->displayableBanners());
        }
        return $this->bannerRepository->displayableBanners();
    }

    public function searchBanner($value){
        return $this->bannerRepository->getBannerSearch($value);
    }

    public function createBanner(BannerRequest $request, $image)
    {
        $this->bannerRepository->create($request->fields(attributes: [
            'image_path' => $image
        ]));
    }

    public function updateBanner(BannerRequest $request, $bannerId, $imageUrl)
    {
        return $this->bannerRepository->update($request->fields(attributes: [
            'image_path' => $imageUrl
        ]), $bannerId);
    }

    public function updateBannerStatus(Banner $banner, $status)
    {
        return $this->bannerRepository->update([
            'status' => (bool)$status
        ], $banner->id);
    }

    public function deleteBanner($id)
    {
        return $this->bannerRepository->delete($id);
    }

    public function deleteImages($image_path){
        if(isset($image_path)) {
            foreach ($image_path['indexArray'] as $path) {
                $this->imageService->deleteIndex($path);
            }
        }
    }

    public function uploadImage($image)
    {
        $this->imageService->setExclusiveDirectory('uploads' . DIRECTORY_SEPARATOR . 'banners');

        $file = new Base64File($this->imageService, $image);
        $upload = new UploadService($file);
        $imageAddress = $upload->uploadIndexFile();

        return $imageAddress ?? false;
    }

}
