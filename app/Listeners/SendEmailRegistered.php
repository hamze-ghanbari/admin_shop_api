<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Http\Controllers\Api\V1\Services\OtpService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailRegistered implements  ShouldQueue
{
    public bool $afterCommit = true;

    public string $queue = 'EmailRegistered';

    public function __construct(
        public OtpService $otpService
    )
    {
        //
    }

    public function handle(UserRegistered $event): void
    {
        $this->otpService->sendEmail($event->code, $event->userName);
    }
}
