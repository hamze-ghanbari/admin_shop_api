<?php

namespace App\Http\Services\UploadService\Algoritms;

use App\Http\Services\ImageService\ImageService;

class File implements \App\Http\Services\UploadService\UploadInterface
{
    public function __construct(
    public ImageService $imageService,
    public $image
    ){}

    public function upload(): string
    {
        return $this->imageService->save($this->image);
    }

}
