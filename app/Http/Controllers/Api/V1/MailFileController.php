<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\MailFileService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MailFileRequest;
use App\Http\Resources\MailFileCollection;
use App\Http\Services\ImageService\ImageService;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\Mail;
use App\Models\MailFile;
use App\Traits\Response\ApiResponse;

class MailFileController extends Controller
{
    use ApiResponse;

    public function __construct(
        public MailFileService $mailFileService,
        public PolicyService   $policyService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:mailFile,5')->only('store', 'update', 'changeStatus');
    }

    public function index(Mail $mail)
    {
        if (!$this->policyService->authorize(['admin'], ['read-mail-file']))
            return $this->forbiddenResponse();

        return new MailFileCollection($this->mailFileService->getAllMailFiles($mail->id));
    }

    public function store(MailFileRequest $request, Mail $mail)
    {
        if (!$this->policyService->authorize(['admin'], ['create-mail-file']))
            return $this->forbiddenResponse();

        $imageAddress = $this->mailFileService->uploadFile($request->input('file_path'));
        if (!$imageAddress) {
            return $this->serverError('خطا در آپلود تصویر');
        }

        $this->mailFileService->createMailFile($request, $mail->id, ['path' => $imageAddress, 'size' => 4, 'mime' => 'image/jpeg']);
        return $this->apiResponse(null);
    }

    public function update(MailFileRequest $request, Mail $mail, MailFile $file)
    {
        if (!$this->policyService->authorize(['admin'], ['update-mail-file']))
            return $this->forbiddenResponse();

        $imageAddress = $this->mailFileService->uploadFile($request->input('file_path'));
        if (!$imageAddress) {
            return $this->serverError('خطا در آپلود تصویر');
        }

        $updated = $this->mailFileService->updateMailFile($request, $file->id, $mail->id, ['path' => $imageAddress, 'size' => 4, 'mime' => 'image/jpeg']);
        return $this->apiResponse(null, hasError: !(bool)$updated);
    }

    public function changeStatus(Mail $mail, MailFile $file, $status)
    {
        if (!$this->policyService->authorize(['admin'], ['update-mail-file']))
            return $this->forbiddenResponse();

        $updated = $this->mailFileService->updateMailFileStatus($file, $status);

        if ($updated) {
            return $this->apiResponse(null);
        } else {
            return $this->serverError('خطا در ویرایش وضعیت ایمیل');
        }
    }


    public function destroy(ImageService $imageService,Mail $mail, MailFile $file)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-mail-file']))
            return $this->forbiddenResponse();

        $mailDelete = $this->mailFileService->deleteMailFile($file->id);
        if($mailDelete){
            $imageService->deleteImage($file->file_path);
        }
        return $this->apiResponse(null, hasError: (bool)$mailDelete);
    }
}
