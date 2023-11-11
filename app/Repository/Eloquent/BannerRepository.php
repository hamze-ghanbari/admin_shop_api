<?php

namespace App\Repository\Eloquent;

use App\Enums\StatusEnum;
use App\Models\Banner;
use App\Repository\Contracts\BannerRepositoryInterface;
use Carbon\Carbon;

class BannerRepository extends BaseRepository implements BannerRepositoryInterface
{
    public function model()
    {
        return Banner::class;
    }

    public function getBannerSearch($value){
        return $this->getModel()->search($value)->paginate();
    }

    public function displayableBanners(){
        $now = Carbon::now()->toDateTimeString();
        return $this->getModel()->where('start_date', '<', $now)->where('end_date', '>', $now)->
            where('status', StatusEnum::Active->value)->paginate();
    }

}
