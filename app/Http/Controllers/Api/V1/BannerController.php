<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\BannerService;
use App\Http\Requests\BannerRequest;
use App\Http\Resources\BannerCollection;
use App\Http\Resources\BannerResource;
use App\Http\Services\ImageService\ImageService;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use App\Traits\Response\ApiResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use ApiResponse;

    public function __construct(
        public PolicyService $policyService,
        public BannerService $bannerService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:banner,5')->only('store', 'update', 'changeStatus');
    }

    public function index()
    {
        if (!$this->policyService->authorize(['admin'], ['read-banner']))
            return $this->forbiddenResponse();

        return new BannerCollection($this->bannerService->getAllBanners());
    }

    public function displayableBanners(){
        if (!$this->policyService->authorize(['admin'], ['read-banner']))
            return $this->forbiddenResponse();

        return new BannerCollection($this->bannerService->getDisplayableBanners());
    }

    public function searchBanner(Request $request)
    {
        if (!$this->policyService->authorize(['admin'], ['read-banner']))
            return $this->forbiddenResponse();

        return new BannerCollection($this->bannerService->searchBanner($request->input('search')));
    }

    public function store(BannerRequest $request)
    {
        if (!$this->policyService->authorize(['admin'], ['create-banner']))
            return $this->forbiddenResponse();

        $image = $request->input('image_path');
        $imageAddress = $this->bannerService->uploadImage($image);

        if (!$imageAddress) {
            return $this->serverError('خطا در آپلود تصویر');
        }

        $this->bannerService->createBanner($request, $imageAddress);
        return $this->apiResponse(null);
    }


    public function show(Banner $banner)
    {
        if (!$this->policyService->authorize(['admin'], ['read-banner']))
            return $this->forbiddenResponse();

        return new BannerResource($banner);
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        if (!$this->policyService->authorize(['admin'], ['update-banner']))
            return $this->forbiddenResponse();

        $image = $request->input('image_path');
        $imageAddress = $this->bannerService->uploadImage($image);

        if (!$imageAddress) {
            return $this->serverError('خطا در آپلود تصویر');
        }

        $this->bannerService->updateBanner($request, $banner->id, $imageAddress);
        return $this->apiResponse(null);
    }

    public function changeStatus(Banner $banner, $status)
    {
        if (!$this->policyService->authorize(['admin'], ['update-banner']))
            return $this->forbiddenResponse();

        $updated = $this->bannerService->updateBannerStatus($banner, $status);

        if ($updated) {
            return $this->apiResponse(null);
        } else {
            return $this->serverError('خطا در ویرایش وضعیت بنر');
        }
    }

    public function destroy(ImageService $imageService, Banner $banner)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-banner']))
            return $this->forbiddenResponse();

        $bannerDelete = $this->bannerService->deleteBanner($banner->id);

        $this->bannerService->deleteImages($banner->image_path);
        return $this->apiResponse(null, hasError: (bool)$bannerDelete);
    }
}
