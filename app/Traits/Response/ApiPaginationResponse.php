<?php

namespace App\Traits\Response;

use Illuminate\Http\Request;

trait ApiPaginationResponse
{

    public function paginationInformation($request, $paginated, $default)
    {
        unset($default['meta']['links']);
        unset($default['links']);
        return $default;
    }

    public function with(Request $request)
    {
        return [
            'status' => 200,
            'hasError' => false,
            'message' => null,
        ];
    }

}
