<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\V1\SmsService;
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
//        $code = '9999';
        $code = $this->smsService->generateCode();
        $msg = __('auth.new_password') . $code;
        $this->smsService->send($msg, $phone);
        SmsVerification::create([
            'phone' => $phone,
            'status' => SmsVerification::STATUS_PENDING,
        ]);
        return response();
    }

}
