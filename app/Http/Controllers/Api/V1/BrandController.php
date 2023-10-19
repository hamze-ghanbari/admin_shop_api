<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\BrandService;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandCollection;
use App\Http\Services\ImageService\ImageService;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\Brand;
use App\Traits\ApiResponse;
use App\Traits\ValidationResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use ApiResponse, ValidationResponse;

    public function __construct(
        public BrandService $brandService,
        public PolicyService   $policyService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:5')->only('store', 'update', 'changeStatus');
    }

    public function index()
    {
        if (!$this->policyService->authorize(['admin'], ['read-brand']))
            return $this->forbiddenResponse();

        return new BrandCollection($this->brandService->getAllBrands());
    }

    public function searchBrand(Request $request)
    {
        if (!$this->policyService->authorize(['admin'], ['read-brand']))
            return $this->forbiddenResponse();

        return new BrandCollection($this->brandService->searchBrand($request->input('search')));
    }

    public function store(BrandRequest $request)
    {
        if (!$this->policyService->authorize(['admin'], ['create-brand']))
            return $this->forbiddenResponse();

        if ($this->brandService->brandExists($request->input('name'))) {
            return $this->failedValidationResponse('این برند قبلا ثبت شده است', 409);
        }

        $type = 'base64';
        $image = $request->input('image');

        $imageAddress = $this->brandService->uploadImage($image, $type);

        if (!$imageAddress) {
            return $this->serverError('خطا در آپلود تصویر');
        }

        $this->brandService->createBrand($request, $imageAddress);
        return $this->apiResponse(null);
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        if (!$this->policyService->authorize(['admin'], ['update-brand']))
            return $this->forbiddenResponse();

        try {
            $type = 'base64';
            $image = $request->input('image');
            $imageAddress = $this->brandService->uploadImage($image, $type);

            if (!$imageAddress) {
                return $this->serverError('خطا در آپلود تصویر');
            }

            $this->brandService->updateBrand($request, $brand->id, $imageAddress);
            return $this->apiResponse(null);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return $this->serverError('این برند قبلا ثبت شده است');
            } else {
                return $this->serverError('خطا در ویرایش برند');
            }
        }
    }

    public function changeStatus(Brand $brand, $status)
    {
        if (!$this->policyService->authorize(['admin'], ['update-brand']))
            return $this->forbiddenResponse();

        $updated = $this->brandService->updateBrandStatus($brand, $status);

        if ($updated) {
            return $this->apiResponse(null);
        } else {
            return $this->serverError('خطا در ویرایش وضعیت برند');
        }
    }

    public function destroy(ImageService $imageService, Brand $brand)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-brand']))
            return $this->forbiddenResponse();

        $brandDelete = $this->brandService->deleteBrand($brand->id);

        if ($brandDelete) {
            $imageService->deleteImage($brand->image);
            return $this->apiResponse(null, hasError: (bool)$brandDelete);
        } else {
            return $this->apiResponse(null, hasError: (bool)$brandDelete);
        }
    }

}
