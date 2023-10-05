<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Enums\ActivationEnum;
use App\Enums\StatusEnum;
use App\Enums\TypeEnum;
use App\Enums\UsedEnum;
use App\Http\Services\MessageService\Algoritms\Email\EmailService;
use App\Http\Services\MessageService\MessageService;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\User;
use App\Repository\Contracts\OtpRepositoryInterface;
use App\Repository\Contracts\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OtpService
{

    private TypeEnum $type = TypeEnum::Mobile;
    private User|null $user = null;

    public function __construct(
        public OtpRepositoryInterface  $otpRepository,
        public UserRepositoryInterface $userRepository
    )
    {
    }


    private function getUserByEmail($email)
    {
        $this->type = TypeEnum::Email;
        $this->user = $this->userRepository->getUserByField('email', $email);
        if (empty($this->user)) {
            return $email;
        }
    }

    private function getUserByMobile($mobile)
    {
        $this->type = TypeEnum::Mobile;
        $this->user = $this->userRepository->getUserByField('mobile', $mobile);
        if (empty($this->user)) {
            return $mobile;
        }
    }

    public function checkUserName($userName)
    {
        $newUser = null;
        if (preg_match('/^' . config('constants.email_regex') . '$/', $userName)) {

           $newUser['email'] = $this->getUserByEmail($userName);

        } elseif (preg_match('/^' . config('constants.mobile_regex') . '$/', $userName)) {

           $newUser['mobile'] = $this->getUserByMobile($userName);

        }

        return [
            'type' => $this->type,
            'user' => $this->user,
            'newUser' => $newUser
        ];
    }

    public function createUser($newUser)
    {
        $newUser['activation'] = ActivationEnum::UserActive->value;
        return $this->userRepository->create($newUser);
    }

    public function createOtp($userId, $userName, $type): Otp
    {
        $otpCode = substr(rand(0, microtime(true)), 0, 5);
        $token = Str::random(60);

        return $this->otpRepository->create([
            'token' => $token,
            'user_id' => $userId,
            'otp_code' => $otpCode,
            'login_id' => $userName,
            'type' => $type
        ]);
    }

    public function getOtp($token): mixed
    {
        return $this->otpRepository->findWhere([
            'token' => $token,
            'used' => UsedEnum::NotUsed->value,
            'status' => StatusEnum::Active->value,
//            ['created_at', '<=', Carbon::now()->subMinutes(2)->toDateTimeString()]
        ])->first();

    }

    public function getOtpWithUser($token)
    {
        return $this->otpRepository->findWhere(['token' => $token])->first();
    }

    public function updateOtpCode($otp)
    {
        // update current otp code
        $this->otpRepository->update([
            'used' => UsedEnum::Used->value,
            'status' => StatusEnum::InActive->value
        ], $otp->id);

        // update other otp code
        $this->otpRepository
            ->findWhere(['user_id' => $otp->user_id, 'status' => StatusEnum::Active->value])
            ->update(['status' => StatusEnum::InActive->value]);
    }

    public function userVerify($userId, $verifyField)
    {
        $this->userRepository->update([
            $verifyField => Carbon::now()
        ], $userId);
    }

    public function getUserById($userId)
    {
        return $this->userRepository->find($userId);
    }

    public function userLogin($user)
    {
        Auth::login($user);
    }

    public function logout($request)
    {
        $request->user()->token()->revoke();
    }

    public function sendEmail($otpCode, $userName)
    {
        $emailService = new EmailService();
        $details = [
            'title' => 'کد تایید دیجی کالا',
            'code' => "$otpCode"
        ];
        $emailService
            ->details($details)
            ->mailClass(OtpMail::class)
            ->subject('کد احراز هویت')
            ->to($userName);

        $messagesService = new MessageService($emailService);
        $messagesService->send();
    }

    public function sendSms()
    {

    }


}
