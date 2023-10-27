<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Services\MailService;
use App\Http\Resources\MailCollection;
use App\Http\Resources\MailResource;
use App\Http\Services\PolicyService\PolicyService;
use App\Models\Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\MailRequest;
use App\Traits\Response\ApiResponse;
use Illuminate\Http\Request;

class MailController extends Controller
{
    use ApiResponse;

    public function __construct(
        public MailService   $mailService,
        public PolicyService $policyService
    )
    {
        $this->middleware('auth:api');
        $this->middleware('limiter:mail,5')->only('store', 'update', 'changeStatus');
    }

    public function index()
    {
        if (!$this->policyService->authorize(['admin'], ['read-mail']))
            return $this->forbiddenResponse();

        return new MailCollection($this->mailService->getAllMails());
    }

    public function searchMail(Request $request)
    {
        if (!$this->policyService->authorize(['admin'], ['read-mail']))
            return $this->forbiddenResponse();

        return new MailCollection($this->mailService->searchMail($request->input('search')));
    }

    public function sendGroupMail(Mail $mail){
        $this->mailService->dispatchGroupEmail($mail);
        return $this->apiResponse(null);
    }

    public function sendSingleMail(Mail $mail){
        $this->mailService->dispatchSingleEmail($mail);
        return $this->apiResponse(null);
    }

    public function store(MailRequest $request)
    {
        if (!$this->policyService->authorize(['admin'], ['create-mail']))
            return $this->forbiddenResponse();

        $this->mailService->createMail($request);
        return $this->apiResponse(null);
    }


    public function show(Mail $mail)
    {
        if (!$this->policyService->authorize(['admin'], ['read-mail']))
            return $this->forbiddenResponse();

        return new MailResource($mail);
    }

    public function update(MailRequest $request, Mail $mail)
    {
        if (!$this->policyService->authorize(['admin'], ['update-mail']))
            return $this->forbiddenResponse();

        $updated = $this->mailService->updateMail($request, $mail->id);
        return $this->apiResponse(null, hasError: !(bool)$updated);
    }

    public function changeStatus(Mail $mail, $status)
    {
        if (!$this->policyService->authorize(['admin'], ['update-mail']))
            return $this->forbiddenResponse();

        $updated = $this->mailService->updateMailStatus($mail, $status);

        if ($updated) {
            return $this->apiResponse(null);
        } else {
            return $this->serverError('خطا در ویرایش وضعیت ایمیل');
        }
    }


    public function destroy(Mail $mail)
    {
        if (!$this->policyService->authorize(['admin'], ['delete-mail']))
            return $this->forbiddenResponse();

        $mailDelete = $this->mailService->deleteMail($mail->id);

        if ($mailDelete) {
//            $imageService->deleteImage($category->image);
            return $this->apiResponse(null, hasError: (bool)$mailDelete);
        } else {
            return $this->apiResponse(null, hasError: (bool)$mailDelete);
        }
    }
}
