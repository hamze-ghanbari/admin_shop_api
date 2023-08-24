<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\TypeEnum;
use App\Http\Controllers\Api\V1\Services\OtpService;
use App\Http\Controllers\Controller;
use App\Http\Resources\OtpCollection;
use App\Http\Resources\OtpResource;
use App\Models\Otp;
use App\Http\Requests\OtpRequest;
use App\Models\User;
use App\Repository\Contracts\OtpRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class OtpController extends Controller
{

    public function __construct(
        public OtpService $otpService,
        public OtpRepositoryInterface $otpRepository
    )
    {
    }

    public function ggg(){

//        return (new OtpCollection($this->otpRepository->paginate(10, ['id', 'otp_code', 'login_id', 'type', 'status', 'user_id'])))
//            ->additional([
//                'hasError' => false
//            ]);
//        return OtpResource::collection($this->otpRepository->all());
        return (new OtpResource($this->otpRepository->findOrFail(18)));
    }

    public function otp(OtpRequest $request)
    {
        $userName = $request->input('user_name');
        $data = $this->otpService->checkUserName($userName, $request);

        DB::beginTransaction();
        try {
            $user = null;
            if (empty($data['user'])) {
                $user = $this->otpService->createUser($data['newUser']);
            } else {
                $user = $data['user'];
                if (isset($user->deleted_at)) {
                    return response()->json([
                        'message' => 'حساب کاربری مسدود شده است',
                        'status' => 401,
                        'hasError' => true,
                        'result' => null
                    ], 401);
                }
            }
//            return response()->json([$user, $user->id, $userName, $data['type']]);
            $otp = $this->otpService->createOtp($user->id, $userName, $data['type']);

            DB::commit();
        } catch (\Exception) {
            DB::rollback();
            return response()->json([
                'message' => 'حساب کاربری مسدود شده است',
                'status' => 5,
                'hasError' => true,
                'result' => null
            ], 401);
        }

        if ($data['type'] === TypeEnum::Email) {
            $this->otpService->sendEmail($otp->otp_code, $userName);
        } elseif ($data['type'] === TypeEnum::Mobile) {
            // send sms
        }
        return response()->json([
            'message' => null,
            'status' => 200,
            'hasError' => false,
            'result' => ['token' => $otp->token, 'code' => $otp->otp_code]
        ]);
    }

    public function confirm(OtpRequest $request)
    {
        $token = $request->input('token');
        $otp = $this->otpService->getOtp($token);
        $errorMessage = 'کد وارد شده معتبر نمی باشد';

        if (empty($otp)) {
            return response()->json([
                'message' => $errorMessage,
                'status' => 419,
                'hasError' => true,
                'result' => null
            ], 419);
        }

        if ($otp->otp_code !== $request->input('confirm_code')) {
            return response()->json([
                'message' => $errorMessage,
                'status' => 419,
                'hasError' => true,
                'result' => null
            ], 419);
        }

//        DB::beginTransaction();
//        try {

             $this->otpService->updateOtpCode($otp);

            $user = $this->otpService->getUserById($otp->user_id);

            if ($otp->type == TypeEnum::Email->value && empty($user->email_verified_at)) {
                $this->otpService->userVerify($user->id, 'email_verified_at');
            } elseif ($otp->type == TypeEnum::Mobile->value && empty($user->mobile_verified_at)) {
                $this->otpService->userVerify($user->id, 'mobile_verified_at');
            }

//            $userLoggedIn = $this->otpService->userLogin($user);

            $accessToken = $user->createToken('Access Token')->plainTextToken;
//            $expireAt = $accessToken->expires_at;
//                return response()->json([auth()->user()]);
//            DB::commit();
            return response()->json([
                'message' => null,
                'status' => 200,
                'hasError' => false,
                'result' => [
                    'user' => $user,
                    'accessToken' => $accessToken,
                    'expireAt' => '$expireAt'
//                    'expireAt' => Carbon::parse('$expireAt')->toDateTimeString()
                ]
            ]);
//        } catch (\Exception) {
//            DB::rollBack();
            return response()->json([
                'message' => 'خطا در برقراری ارتباط',
                'status' => 401,
                'hasError' => true,
                'result' => null
            ], 401);
//        }
    }

    public function resendOtpCode($token)
    {

        $otp = $this->otpService->getOtpWithUser($token);

        if (!isset($otp) || Carbon::now()->toDateTimeString() < (new Carbon($otp->created_at))->addMinutes(config('auth_module.time'))->toDateTimeString()) {
            return redirect()->back();
        }

        $otpData = $this->otpService->createOtp($otp->user_id, $otp->login_id, $otp->type);

        if ($otp->type === TypeEnum::Email->value) {
            $this->otpService->sendEmail($otpData->otp_code, $otp->login_id);
        } elseif ($otp->type === TypeEnum::Mobile->value) {
            // send sms
        }

        return response()->json([
            'message' => null,
            'status' => 200,
            'hasError' => false,
            'result' => [
                'token' => $token
            ]
        ]);

    }

    public function logout(Request $request)
    {
        $this->otpService->logOut($request);
        return response()->json([
            'message' => null,
            'status' => 200,
            'hasError' => false,
            'result' => null
        ]);
    }

}
