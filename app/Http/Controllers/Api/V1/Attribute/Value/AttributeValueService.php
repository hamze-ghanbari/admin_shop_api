<?php

namespace App\Http\Controllers\Api\V1\Attribute\Value;

use App\Http\Requests\AttributeValueRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Http\Services\ImageService\ImageService;
use App\Models\AttributeCategory;
use App\Repository\Contracts\AttributeRepositoryInterface;
use App\Repository\Contracts\AttributeValueRepositoryInterface;

class AttributeValueService
{

    public function __construct(
        public ImageService                $imageService,
        public AttributeValueRepositoryInterface $attributeValueRepository,
        public CacheApiService $cacheApiService
    )
    {
    }

    public function getAllAttributeValues(AttributeCategory $attributeCategory)
    {
        if($this->cacheApiService->useCache('attributes')){
            return $this->cacheApiService->cacheApi('attributes', $attributeCategory->values);
        }
        return $attributeCategory->values;
    }

//    public function searchAttribute($value){
//        return $this->attributeValueRepository->getAttributeSearch($value);
//    }

    public function createAttributeValue(AttributeValueRequest $request, $attributeId)
    {
        $values = $request->fields(attributes: [
            'attribute_category_id' => $attributeId
        ]);

        $values['value'] = json_encode(['value' => $values['value'], 'price_increase' => $values['price_increase']]);

        $this->attributeValueRepository->create($values);
    }

    public function updateAttributeValue(AttributeValueRequest $request, $attributeId, $valueId)
    {
        $values = $request->fields(attributes: [
            'attribute_category_id' => $attributeId
        ]);

        $values['value'] = json_encode(['value' => $values['value'], 'price_increase' => $values['price_increase']]);

        return $this->attributeValueRepository->update($values, $valueId);
    }

    public function deleteAttributeValue($valueId)
    {
        return $this->attributeValueRepository->delete($valueId);
    }


}
