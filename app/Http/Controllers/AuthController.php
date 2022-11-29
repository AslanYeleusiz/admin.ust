<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SmsVerification;
use App\Http\Requests\Auth\CheckPhoneRequest;
use Illuminate\Validation\ValidationException;
use App\Services\V1\SmsService;
use App\Helpers\Helper;


class AuthController extends Controller
{
    protected $guard = 'api';

    public $smsService;
    public function __construct(SmsService $smsService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'checkPhone']]);
        $this->smsService = $smsService;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {

        $credentials = request(['phone','password']);
        $user = User::where('tel_num', $credentials['phone'])->first();

        if(empty($user) || Hash('sha1', $credentials['password']) !== $user->password){
            throw ValidationException::withMessages([
                'password' => [__('auth.Phone or password is incorrect')]
            ]);
        }
        if(!$user->phone_activated){
            $user->phone_activated = 1;
            $user->save();
        }
        $token = auth()->login($user);
        return $this->responseWithToken($token);
//        return response()->json(auth()->attempt($credentials));
//        if (! $token = auth()->attempt($credentials)) {
//            return response()->json(['error' => 'Unauthorized'], 401);
//        }
//
//        return $this->respondWithToken($token);
    }

    public function checkPhone(CheckPhoneRequest $request) {
        $user = User::where('tel_num', $request->phone)->first();
        if(!empty($user)){
            return response()->json([
                'loginOpen' => 2,
            ]);
        }
        $phone = Helper::clearPhoneMask($request->phone);
//        $code = 'password';
        $code = rand(1000,9999);
        $msg = "ust.kz Жеке кабинетке кіру Тел: +7".$request->phone.' құпия сөз: '. $code;
        $this->smsService->send($msg, $phone);

        $email = $this->smsService->generateCode();

        SmsVerification::create([
            'phone' => $phone,
            'status' => SmsVerification::STATUS_PENDING,
        ]);

        $new_user = User::create([
            'tel_num' => $request->phone,
            'user_status_id' => 1,
            'email' => $email.'@mail.ru',
            'password' => Hash('sha1', $code),
            'real_password' => $code,
            'rep_pass' => Hash('sha1', $code),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $new_user->s_name = 'Қолданушы';
        $new_user->username = '№'.$new_user->id;
        $new_user->email = 'user'.$new_user->id.'@gmail.com';
        $new_user->save();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->responseWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
