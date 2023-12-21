<?php

namespace App\Http\Controllers\Api\V1\Attribute;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeCategoryRequest;
use App\Http\Resources\AttributeCategoryCollection;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\AttributeCategory;
use App\Traits\Response\ApiResponse;
use App\Traits\Response\ValidationResponse;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    use ApiResponse, ValidationResponse;

    public function __construct(
        public AttributeService $attributeService,
        public PolicyService    $policyService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:attribute,5')->only('store', 'update');
    }

    public function index()
    {
        if (!$this->policyService->authorize(['admin'], ['read-attribute']))
            return $this->forbiddenResponse();

        return new AttributeCategoryCollection($this->attributeService->getAllAttributes());
    }

    public function searchAttribute(Request $request)
    {
        if (!$this->policyService->authorize(['admin'], ['read-attribute']))
            return $this->forbiddenResponse();

        return new AttributeCategoryCollection($this->attributeService->searchAttribute($request->input('search')));
    }

    public function store(AttributeCategoryRequest $request)
    {
        if (!$this->policyService->authorize(['admin'], ['create-attribute']))
            return $this->forbiddenResponse();

        $this->attributeService->createAttribute($request);
        return $this->apiResponse(null);
    }

    public function update(AttributeCategoryRequest $request, AttributeCategory $attribute)
    {
        if (!$this->policyService->authorize(['admin'], ['update-attribute']))
            return $this->forbiddenResponse();

        $this->attributeService->updateAttribute($request, $attribute->id);
        return $this->apiResponse(null);
    }

    public function destroy(AttributeCategory $attribute)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-attribute']))
            return $this->forbiddenResponse();

        $attributeDelete = $this->attributeService->deleteAttribute($attribute->id);
        return $this->apiResponse(null, hasError: !(bool)$attributeDelete);

    }

}
