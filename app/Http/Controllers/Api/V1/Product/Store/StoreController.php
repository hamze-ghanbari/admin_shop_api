<?php

namespace App\Http\Controllers\Api\V1\Product\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\Product;
use App\Traits\Response\ApiResponse;
use App\Traits\Response\ValidationResponse;

class StoreController extends Controller
{
    use ApiResponse, ValidationResponse;

    public function __construct(
        public StoreService  $storeService,
        public PolicyService $policyService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:store,5')->only('store', 'update');
    }

    public function store(StoreRequest $request, Product $product){
        $this->storeService->store($product, $request->input('marketable_number'));
        return $this->apiResponse(null);
    }

    public function update(StoreRequest $request, Product $product){
        $updated = $this->storeService->update($product, $request);
        if ($updated) {
            return $this->apiResponse(null);
        } else {
            return $this->serverError('خطا در ویرایش');
        }
    }
}
