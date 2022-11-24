<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\Auth\CheckPhoneRequest;
use Illuminate\Validation\ValidationException;
use App\Services\V1\SmsService;
use App\Helpers\Helper;


class AuthController extends Controller
{
    public $smsService;
    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }
    protected $guard = 'api';
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'checkPhone']]);
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

        $password = $this->smsService->generateCode();
        $msg = __('auth.new_password') . $password;
        $phone = Helper::clearPhoneMask($request->phone);
        $this->smsService->send($msg, $phone);

        $email = $this->smsService->generateCode();

        $new_user = User::create([
            'tel_num' => $request->phone,
            'user_status_id' => 1,
            'email' => $email.'@mail.ru',
            'password' => Hash('sha1', $password),
            'real_password' => $password,
            'rep_pass' => Hash('sha1', $password),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $new_user->s_name = 'Қолданушы';
        $new_user->username = '№'.$new_user->id;
        $new_user->email = 'user'.$new_user->id.'@gmail.com';
        $new_user->save();
        SmsVerification::create([
            'phone' => $phone,
            'status' => SmsVerification::STATUS_PENDING,
        ]);

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
