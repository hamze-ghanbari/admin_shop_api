<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public static $wrap = 'items';

//    public function paginationInformation($request, $paginated, $default)
//    {
////        unset($default['meta']['links']);
////        unset($default['links']);
//        return $default;
//    }

//    public function with(Request $request): array
//    {
//        return [
//            'hasError' => false
//        ];
//    }
//
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
