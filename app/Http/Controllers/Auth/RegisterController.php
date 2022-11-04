<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
//use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

//    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function register(Request $request) {

        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        $token = auth()->login($user);

        return $this->responseWithToken($token);

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = array(
            'required' => 'Бұл жол толтырылуы керек.',
            'string' => 'Бұл жол тармақ болуы керек.',
            'min' => 'Бұл жолда кем дегенде :min таңба болуы керек.',
            'max' => 'Бұл жол шектік :max таңбадан асып кетті.',
            'unique' => 'Бұл электрондық пошта бос емес!',
            'email' => 'Бұл жолда синтаксистік қате бар',
            'required_with' => ':Attribute жолы :value жолына сәйкес болуы керек.',
            'same' => 'Бұл жол password жолына сәйкес болуы керек.'
        );
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255','unique:user,email'],
            'tel_num' => ['required', 'string', 'min:8'],
            'username' => ['required', 'string', 'max:64'],
            'l_name' => ['required', 'string', 'max:64'],
            's_name' => ['required', 'string', 'max:64'],
            'user_status_id' => ['required'],
            'password' => ['required', 'string', 'min:8', 'max:22', 'required_with:password_confirm'],
            'password_confirm' => ['required', 'string', 'min:8', 'max:16', 'same:password'],
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            's_name' => $data['s_name'],
            'l_name' => $data['l_name'],
            'tel_num' => $data['tel_num'],
            'user_status_id' => $data['user_status_id'],
            'email' => $data['email'],
            'password' => Hash('sha1', $data['password']),
            'real_password' => $data['password'],
            'rep_pass' => Hash('sha1', $data['password']),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    protected function responseWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
