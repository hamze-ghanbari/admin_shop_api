<?php

namespace App\Http\Services\UploadService\Algoritms;

use App\Http\Services\ImageService\ImageService;

class Base64File implements \App\Http\Services\UploadService\UploadInterface
{
    public function __construct(
        public ImageService $imageService,
        public $image
    ){}

    public function upload(): string
    {
       return $this->imageService->base64Save($this->image);
    }
}
