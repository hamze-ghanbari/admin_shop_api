<?php

namespace App\Http\Resources;

use App\Traits\Response\ApiPaginationResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AttributeValueCollection extends ResourceCollection
{
    use ApiPaginationResponse;
    public static $wrap = 'result';

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
