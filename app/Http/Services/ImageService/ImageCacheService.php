<?php

namespace App\Http\Services\ImageService;

use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;

class ImageCacheService
{

    public function cache($imagePath, $size = ''){

        $imageSize = Config::get('image.cache-image-sizes');
        if(!isset($imageSize[$size])){
            $size = Config::get('image.default-current-cache-image');
        }
        $width = $imageSize[$size]['width'];
        $height = $imageSize[$size]['height'];

        if(file_exists($imagePath)){
            $img = Image::cache(function($image) use($imagePath, $width, $height){
                return $image->make($imagePath)->fit($width, $height);
            }, Config::get('image.image-cache-life-time'), true);

            return $img->response();
        }else{
            $img = Image::canvas($width, $height, '#000000')->text('image not found', $width / 2, $height / 2, function ($font){
                $font->color('#ffffff');
                $font->align('center');
                $font->valign('center');
            });

            return $img->response();
        }


    }

}
