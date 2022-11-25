<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\V1\SmsService;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;
use App\Models\User;
use App\Models\SmsVerification;

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

}
