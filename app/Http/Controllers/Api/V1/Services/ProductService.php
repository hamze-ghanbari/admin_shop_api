<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Http\Requests\ProductRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Http\Services\ImageService\ImageService;
use App\Repository\Contracts\ProductRepositoryInterface;
use App\Models\Product;

class ProductService
{

    public function __construct(
        public ProductRepositoryInterface $productRepository,
        public CacheApiService $cacheApiService
    )
    {
    }

    public function getAllProducts()
    {
        if($this->cacheApiService->useCache('products')){
            return $this->cacheApiService->cacheApi('products', $this->productRepository->paginate());
        }
        return $this->productRepository->paginate();
    }

    public function searchProduct($value){
        return $this->productRepository->getProductSearch($value);
    }

    public function productExists(string $name)
    {
        return $this->productRepository->getProductWithTrashed($name);
    }

    public function createProduct(ProductRequest $request)
    {
        $this->productRepository->create($request->fields(attributes: [
            'slug' => $request->fields()['name'],
        ]));
    }

    public function updateProduct(ProductRequest $request, $productId)
    {
        return $this->productRepository->update($request->fields(attributes: [
            'slug' => $request->fields()['name'],
        ]), $productId);
    }

    public function updateProductStatus(Product $product, $status)
    {
        return $this->productRepository->update([
            'status' => (bool)$status
        ], $product->id);
    }

    public function deleteProduct($id)
    {
        return $this->productRepository->delete($id);
    }

}
