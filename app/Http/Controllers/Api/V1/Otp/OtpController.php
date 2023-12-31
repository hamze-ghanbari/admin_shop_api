<?php

namespace App\Http\Controllers\Api\V1\Otp;

use App\Enums\TypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmOtpRequest;
use App\Http\Requests\OtpRequest;
use App\Traits\Response\ApiResponse;
use App\Traits\Response\ValidationResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OtpController extends Controller
{
    use ValidationResponse, ApiResponse;

    public function __construct(public OtpService $otpService)
    {
        $this->middleware('auth:api')->only('logout');
        $this->middleware('authenticated')->except('logout');
        $this->middleware('limiter:otp,5')->except('logout');
    }

    public function otp(OtpRequest $request)
    {
        $userName = $request->input('user_name');
        $data = $this->otpService->checkUserName($userName);

        if (!$data['newUser']) {
            $errorMessage = 'فرمت وارد شده معتبر نمی باشد';
            return $this->failedValidationResponse([
                'user_name' => [
                    $errorMessage
                ]
            ]);
        }
        DB::beginTransaction();
        try {
            $user = null;
            if (empty($data['user'])) {
                $user = $this->otpService->createUser($data['newUser']);
            } else {
                $user = $data['user'];
                if (isset($user->deleted_at)) {
                    return $this->failedValidationResponse([
                        'user_name' => [
                            'حساب کاربری مسدود شده است'
                        ]
                    ]);
                }
            }
            $otp = $this->otpService->createOtp($user->id, $userName, $data['type']);

            DB::commit();
        } catch (\Exception) {
            DB::rollback();
            return $this->failedValidationResponse([
                'user_name' => [
                    'حساب کاربری مسدود شده است'
                ]
            ]);
        }

        if ($data['type'] === TypeEnum::Email) {
            $this->otpService->emailRegisteredEvent($otp->otp_code, $userName);
        } elseif ($data['type'] === TypeEnum::Mobile) {
            // send sms
        }
        return $this->apiResponse([
            'code' => $otp->otp_code,
            'user_name' => $userName
//            'has_account' => isset($data['user'])
        ]);
    }

    public function confirm(ConfirmOtpRequest $request)
    {
        $userName = $request->input('user_name');
        $otp = $this->otpService->getOtp($userName);
//        $token = $request->input('token');
//        $otp = $this->otpService->getOtp($token);
        $errorMessage = 'کد وارد شده معتبر نمی باشد';

        if (empty($otp)) {
            return $this->failedValidationResponse([
                'confirm_code' => [
                    $errorMessage
                ]
            ]);
        }

        if ($otp->otp_code !== $request->input('confirm_code')) {
            return $this->failedValidationResponse([
                'confirm_code' => [
                    $errorMessage
                ]
            ]);
        }

        DB::beginTransaction();
        try {

            $user = $this->otpService->getUserById($otp->user_id);
            if ($otp->type == TypeEnum::Email->value && empty($user->email_verified_at)) {
                $this->otpService->userVerify($user->id, 'email_verified_at');
            } elseif ($otp->type == TypeEnum::Mobile->value && empty($user->mobile_verified_at)) {
                $this->otpService->userVerify($user->id, 'mobile_verified_at');
            }

            $this->otpService->updateOtpCode($otp);

            $this->otpService->userLogin($user);

            $this->otpService->addRoleToUser();

            $accessToken = $this->otpService->generateAccessToken($request);
//            $expireAt = $accessToken->expire;
            DB::commit();
            return $this->apiResponse([
                'user' => auth()->user(),
                'accessToken' => $accessToken,
//                    'expireAt' => $expireAt
//                    'expireAt' => Carbon::parse('$expireAt')->toDateTimeString()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->failedValidationResponse($e->getMessage(), 500);
        }
    }

    public function resendOtpCode(Request $request)
    {
        $userName = $request->input('user_name');
        $otp = $this->otpService->getOtp($userName);

        if (!isset($otp) || Carbon::now()->toDateTimeString() < (new Carbon($otp->created_at))->addMinutes(2)->toDateTimeString()) {
            // time error
            return $this->failedValidationResponse('Not Found', 404);
        }

        $otpData = $this->otpService->createOtp($otp->user_id, $otp->login_id, $otp->type);

        if ($otp->type === TypeEnum::Email->value) {
            $this->otpService->emailRegisteredEvent($otpData->otp_code, $otp->login_id);
        } elseif ($otp->type === TypeEnum::Mobile->value) {
            // send sms
        }

        return $this->apiResponse([
            'code' => $otpData->otp_code,
            'userName' => $userName
            ]);

    }

    public function logout(Request $request)
    {
        $this->otpService->logout($request);

        return $this->apiResponse([], message : 'logout success');
    }

}
