<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Services\ImageService\ImageService;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\Category;
use App\Traits\Response\ApiResponse;
use App\Traits\Response\ValidationResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse, ValidationResponse;

    public function __construct(
        public CategoryService $categoryService,
        public PolicyService   $policyService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:category,5')->only('store', 'update', 'changeStatus');
    }

    public function index()
    {
        if (!$this->policyService->authorize(['admin'], ['read-category']))
            return $this->forbiddenResponse();

        return new CategoryCollection($this->categoryService->getAllCategories());
    }

    public function searchCategory(Request $request)
    {
        if (!$this->policyService->authorize(['admin'], ['read-category']))
            return $this->forbiddenResponse();

        return new CategoryCollection($this->categoryService->searchCategory($request->input('search')));
    }

    public function store(CategoryRequest $request, ImageService $imageService)
    {
        if (!$this->policyService->authorize(['admin'], ['create-category']))
            return $this->forbiddenResponse();

        if ($this->categoryService->categoryExists($request->input('name'))) {
            return $this->failedValidationResponse('این دسته بندی قبلا ثبت شده است', 409);
        }

        $type = 'base64';
        $image = $request->input('image');

        $imageAddress = $this->categoryService->uploadImage($image, $type);

        if (!$imageAddress) {
            return $this->serverError('خطا در آپلود تصویر');
        }

        $this->categoryService->createCategory($request, $imageAddress);
        return $this->apiResponse(null);
    }

    public function update(CategoryRequest $request, ImageService $imageService, Category $category)
    {
        if (!$this->policyService->authorize(['admin'], ['update-category']))
            return $this->forbiddenResponse();

        try {
            $type = 'base64';
            $image = $request->input('image');
            $imageAddress = $this->categoryService->uploadImage($image, $type);

            if (!$imageAddress) {
                return $this->serverError('خطا در آپلود تصویر');
            }

            $this->categoryService->updateCategory($request, $category->id, '$imageAddress');
            return $this->apiResponse(null);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return $this->serverError('این دسته بندی قبلا ثبت شده است');
            } else {
                return $this->serverError('خطا در ویرایش دسته بندی');
            }
        }
    }

    public function changeStatus(Category $category, $status)
    {
        if (!$this->policyService->authorize(['admin'], ['update-category']))
            return $this->forbiddenResponse();

        $updated = $this->categoryService->updateCategoryStatus($category, $status);

        if ($updated) {
            return $this->apiResponse(null);
        } else {
            return $this->serverError('خطا در ویرایش وضعیت دسته بندی');
        }
    }

    public function destroy(ImageService $imageService, Category $category)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-category']))
            return $this->forbiddenResponse();

        $categoryDelete = $this->categoryService->deleteCategory($category->id);

        if ($categoryDelete) {
            $imageService->deleteImage($category->image);
            return $this->apiResponse(null, hasError: (bool)$categoryDelete);
        } else {
            return $this->apiResponse(null, hasError: (bool)$categoryDelete);
        }
    }

}
