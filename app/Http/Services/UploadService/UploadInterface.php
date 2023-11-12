<?php

namespace App\Http\Services\UploadService;

interface UploadInterface
{

    public function upload(): string;

    public function uploadIndexFile(): array | bool;

}
