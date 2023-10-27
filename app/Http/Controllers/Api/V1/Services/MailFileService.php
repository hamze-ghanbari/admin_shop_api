<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Http\Requests\MailFileRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Http\Services\ImageService\ImageService;
use App\Http\Services\UploadService\Algoritms\Base64File;
use App\Http\Services\UploadService\UploadService;
use App\Models\MailFile;
use App\Repository\Contracts\MailFileRepositoryInterface;

class MailFileService
{
    public function __construct(
        public MailFileRepositoryInterface $mailFileRepository,
        public CacheApiService             $cacheApiService,
        public ImageService $imageService
    )
    {
    }

    public function getAllMailFiles()
    {
        return $this->mailFileRepository->paginate();
    }

    public function updateMailFileStatus(MailFile $mailFile, $status)
    {
        return $this->mailFileRepository->update([
            'status' => (bool)$status
        ], $mailFile->id);
    }

    public function updateMailFile(MailFileRequest $request, $mailId)
    {
        return $this->mailFileRepository->update($request->fields(), $mailId);
    }

    public function createMailFile(MailFileRequest $request)
    {
        return $this->mailFileRepository->create($request->fields());
    }

    public function deleteMailFile($id)
    {
        return $this->mailFileRepository->delete($id);
    }


    public function uploadFile($image)
    {
        $this->imageService->setExclusiveDirectory('uploads' . DIRECTORY_SEPARATOR . 'mail_files');

        $file = new Base64File($this->imageService, $image);
        $upload = new UploadService($file);
        $imageAddress = $upload->upload();

        return $imageAddress ?? false;
    }
}
