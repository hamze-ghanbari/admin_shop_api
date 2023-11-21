<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Services\ImageService\ImageService;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\Product;
use App\Traits\Response\ApiResponse;
use App\Traits\Response\ValidationResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse, ValidationResponse;

    public function __construct(
        public ProductService $productService,
        public PolicyService  $policyService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:product,5')->only('store', 'update', 'changeStatus');
    }

    public function index()
    {
        if (!$this->policyService->authorize(['admin'], ['read-product']))
            return $this->forbiddenResponse();

        return new ProductCollection($this->productService->getAllCategories());
    }

    public function searchProduct(Request $request)
    {
        if (!$this->policyService->authorize(['admin'], ['read-product']))
            return $this->forbiddenResponse();

        return new ProductCollection($this->productService->searchProduct($request->input('search')));
    }

    public function store(ProductRequest $request)
    {
        if (!$this->policyService->authorize(['admin'], ['create-product']))
            return $this->forbiddenResponse();

        if ($this->productService->productExists($request->input('name'))) {
            return $this->failedValidationResponse('این محصول قبلا ثبت شده است', 409);
        }

        $this->productService->createProduct($request);
        return $this->apiResponse(null);
    }

    public function update(ProductRequest $request, Product $product)
    {
        if (!$this->policyService->authorize(['admin'], ['update-product']))
            return $this->forbiddenResponse();

        try {
            $this->productService->updateProduct($request, $product->id);
            return $this->apiResponse(null);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return $this->serverError('این محصول قبلا ثبت شده است');
            } else {
                return $this->serverError('خطا در ویرایش محصول');
            }
        }
    }

    public function changeStatus(Product $product, $status)
    {
        if (!$this->policyService->authorize(['admin'], ['update-product']))
            return $this->forbiddenResponse();

        $updated = $this->productService->updateProductStatus($product, $status);

        if ($updated) {
            return $this->apiResponse(null);
        } else {
            return $this->serverError('خطا در ویرایش وضعیت محصول');
        }
    }

    public function destroy(ImageService $imageService, Product $product)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-product']))
            return $this->forbiddenResponse();

        $productDelete = $this->productService->deleteProduct($product->id);

        return $this->apiResponse(null, hasError: (bool)$productDelete);
    }

}
