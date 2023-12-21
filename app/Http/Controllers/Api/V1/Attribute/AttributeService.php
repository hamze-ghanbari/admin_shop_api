<?php

namespace App\Http\Controllers\Api\V1\Attribute;

use App\Http\Requests\AttributeCategoryRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Http\Services\ImageService\ImageService;
use App\Repository\Contracts\AttributeRepositoryInterface;

class AttributeService
{

    public function __construct(
        public ImageService                $imageService,
        public AttributeRepositoryInterface $attributeRepository,
        public CacheApiService $cacheApiService
    )
    {
    }

    public function getAllAttributes()
    {
        if($this->cacheApiService->useCache('attributes')){
            return $this->cacheApiService->cacheApi('attributes', $this->attributeRepository->paginate());
        }
        return $this->attributeRepository->paginate();
    }

    public function searchAttribute($value){
        return $this->attributeRepository->getAttributeSearch($value);
    }

    public function createAttribute(AttributeCategoryRequest $request)
    {
        $this->attributeRepository->create($request->fields());
    }

    public function updateAttribute(AttributeCategoryRequest $request, $attributesId)
    {
        return $this->attributeRepository->update($request->fields(), $attributesId);
    }

    public function deleteAttribute($id)
    {
        return $this->attributeRepository->delete($id);
    }


}
