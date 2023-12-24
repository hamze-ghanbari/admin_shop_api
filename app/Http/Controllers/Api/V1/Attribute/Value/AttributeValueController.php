<?php

namespace App\Http\Controllers\Api\V1\Attribute\Value;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeValueRequest;
use App\Http\Resources\AttributeValueCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\AttributeCategory;
use App\Models\AttributeValueCategory;
use App\Traits\Response\ApiResponse;
use App\Traits\Response\ValidationResponse;

class AttributeValueController extends Controller
{
    use ApiResponse, ValidationResponse;

    public function __construct(
        public AttributeValueService $attributeValueService,
        public PolicyService    $policyService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:attributeValue,5')->only('store', 'update');
    }

    public function index(AttributeCategory $attributeCategory)
    {
        if (!$this->policyService->authorize(['admin'], ['read-attribute']))
            return $this->forbiddenResponse();

        return new AttributeValueCollection($this->attributeValueService->getAllAttributeValues($attributeCategory));
    }

//    public function searchAttribute(Request $request)
//    {
//        if (!$this->policyService->authorize(['admin'], ['read-attribute']))
//            return $this->forbiddenResponse();
//
//        return new AttributeCategoryCollection($this->attributeValueService->searchAttribute($request->input('search')));
//    }


    public function getAttributeProducts(AttributeCategory $attributeCategory){
        dd($attributeCategory->category);
        return new ProductCollection($attributeCategory->category->products);
    }

    public function store(AttributeValueRequest $request, AttributeCategory $attributeCategory)
    {
        if (!$this->policyService->authorize(['admin'], ['create-attribute']))
            return $this->forbiddenResponse();

        $this->attributeValueService->createAttributeValue($request, $attributeCategory->id);
        return $this->apiResponse(null);
    }

    public function update(AttributeValueRequest $request, AttributeCategory $attribute, AttributeValueCategory $attributeValueCategory)
    {
        if (!$this->policyService->authorize(['admin'], ['update-attribute']))
            return $this->forbiddenResponse();

        $this->attributeValueService->updateAttributeValue($request, $attribute->id, $attributeValueCategory->id);
        return $this->apiResponse(null);
    }

    public function destroy(AttributeCategory $attribute, AttributeValueCategory $attributeValueCategory)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-attribute']))
            return $this->forbiddenResponse();

        $attributeDelete = $this->attributeValueService->deleteAttributeValue($attributeValueCategory->id);
        return $this->apiResponse(null, hasError: !(bool)$attributeDelete);
    }

}
