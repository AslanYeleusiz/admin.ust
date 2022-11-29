<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\V1\SmsService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Helpers\Helper;
use App\Models\User;
use App\Models\SmsVerification;
use App\Http\Requests\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{

    public $smsService;
    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function sendSmsResetPassword(Request $request) {
        $phone = Helper::clearPhoneMask($request->phone);
        $user = User::where('tel_num', $request->phone)->first();
        $this->smsService->checkLimitSms($phone);
//        $code = 'password';
        $code = $user->real_password;
        $msg = "<a href='https://ust.kz'>ust.kz</a> Жеке кабинетке кіру Тел: +7".$request->phone.' құпия сөз: '. $code;
        $this->smsService->send($msg, $phone);
        SmsVerification::create([
            'phone' => $phone,
            'status' => SmsVerification::STATUS_PENDING,
        ]);
        return response()->json([
            'success' => true,
            'loginOpen' => 3,
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request) {
        $password = $request->password;
        $user = auth()->guard('api')->user();
        if($user->real_password != $request->oldPassword)
            throw ValidationException::withMessages([
                'oldPassword' => [__('auth.password is incorrect')]
            ]);
        $user->update([
            'password' => Hash('sha1', $password),
            'real_password' => $password,
        ]);

        return response()->json([
            'success' => true,
            'new password' => $password,
        ]);
    }

}
