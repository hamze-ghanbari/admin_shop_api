<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Services\PolicyService\PolicyService;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use App\Traits\Response\ApiResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use ApiResponse;

    public function __construct(
        public PolicyService   $policyService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:banner,5')->only('store', 'update', 'changeStatus');
    }

    public function index()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Banner $banner)
    {
        //
    }

    public function update(Request $request, Banner $banner)
    {
        //
    }

    public function changeStatus(Banner $banner, $status){

    }

    public function destroy(Banner $banner)
    {
        //
    }
}
