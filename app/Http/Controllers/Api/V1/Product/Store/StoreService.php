<?php

namespace App\Http\Controllers\Api\V1\Product\Store;

use App\Http\Requests\StoreRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Http\Services\ImageService\ImageService;
use App\Models\Product;
use App\Repository\Contracts\BrandRepositoryInterface;

class StoreService
{

    public function __construct(
        public ImageService                $imageService,
        public BrandRepositoryInterface $brandRepository,
        public CacheApiService $cacheApiService
    )
    {
    }

    public function store(Product $product, $number){
        $product->increment('marketable_number', $number);
        $product->save();
    }

    public function update(Product $product, StoreRequest $storeRequest){
        return $product->update($storeRequest->fields());
    }


}
