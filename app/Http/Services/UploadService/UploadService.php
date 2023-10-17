<?php

namespace App\Http\Services\UploadService;

class UploadService
{

    public function __construct(
        public UploadInterface $upload
    )
    {
    }

    public function upload(): string
    {
        return $this->upload->upload();
    }
}
