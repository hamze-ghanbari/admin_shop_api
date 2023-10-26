<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\V1\Services\MailService;
use App\Jobs\SendGroupEmail;
use App\Models\Mail;
use App\Repository\Contracts\MailRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class sendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:sendMail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send mail for users';

    /**
     * Execute the console command.
     */
    public function handle(MailService $mailService, MailRepositoryInterface $mailRepository)
    {
        $emails = $mailRepository->getMails();
        foreach ($emails as $email){
            $mailService->dispatchGroupEmail($email);
        }
    }
}
