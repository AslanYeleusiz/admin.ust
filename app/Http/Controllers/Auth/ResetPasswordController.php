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
        $this->smsService->checkLimitSms($phone);
//        $code = 'password';
        $code = $this->smsService->generateCode();
        $msg = __('auth.new_password') . $code;
        $this->smsService->send($msg, $phone);
        SmsVerification::create([
            'phone' => $phone,
            'status' => SmsVerification::STATUS_PENDING,
        ]);
        User::where('tel_num', $request->phone)->first()->update([
            'password' => Hash('sha1', $code),
            'real_password' => $code,
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
