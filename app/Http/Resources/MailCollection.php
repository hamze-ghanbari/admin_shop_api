<?php

namespace App\Http\Resources;

use App\Traits\Response\ApiPaginationResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MailCollection extends ResourceCollection
{
    use ApiPaginationResponse;

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
