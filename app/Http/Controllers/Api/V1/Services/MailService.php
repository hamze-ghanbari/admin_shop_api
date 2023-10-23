<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Http\Requests\MailRequest;
use App\Http\Services\CacheApiService\CacheApiService;
use App\Http\Services\MessageService\Algorithms\Email\EmailService;
use App\Http\Services\MessageService\MessageService;
use App\Jobs\SendEmailToUsers;
use App\Mail\PublicMail;
use App\Models\Mail;
use App\Repository\Contracts\MailRepositoryInterface;

class MailService
{
    public function __construct(
        public MailRepositoryInterface $mailRepository,
        public CacheApiService         $cacheApiService
    )
    {
    }

    public function getAllMails()
    {
        return $this->mailRepository->paginate();
    }

    public function searchMail($value)
    {
        return $this->mailRepository->getMailSearch($value);
    }

    public function updateMailStatus(Mail $mail, $status)
    {
        return $this->mailRepository->update([
            'status' => (bool)$status
        ], $mail->id);
    }

    public function updateMail(MailRequest $request, $mailId)
    {
        return $this->mailRepository->update($request->fields(), $mailId);
    }


    public function createMail(MailRequest $request)
    {
        return $this->mailRepository->create($request->fields());
    }

    public function deleteMail($id)
    {
        return $this->mailRepository->delete($id);
    }

    public function sendMailToUsers(Mail $mail)
    {
        SendEmailToUsers::dispatch($mail)->onQueue('mailUsers');
    }


    public function sendMail(Mail $email)
    {
        // get files from mail files table
        $files = [];
        // get email from newsletters users or users table
        $emails = ['ghanbarih243@gmail.com', 'infogh1000@gmail.com', 'hamzegh5000@gmail.com'];

        $emailService = new EmailService();
        $details = [
            'title' => $email->subject,
            'body' => $email->body
        ];
        $mail = $emailService
            ->details($details)
            ->subject($email->subject)
            ->mailClass(PublicMail::class)
            ->files(['uploads/brands/2023/10/17/G8yOP8cKkEWvzfYsxjEV.jpeg' => ['name' => 'test.jpeg', 'mime' => 'image/jpeg']]);

        foreach ($emails as $email) {
            $mail->to($email);
            $messagesService = new MessageService($emailService);
            $messagesService->send();
        }

    }

}
