<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public static $wrap = 'result';

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
