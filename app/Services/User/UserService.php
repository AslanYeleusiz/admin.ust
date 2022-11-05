<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

/**
 * Class UserService.
 */
class UserService
{
    public function handle($user, $request){

//        foreach($request as $key =>$value){
//            if(empty($key)){
//                $user->$key = $value;
//            }
//        };
        $user->username = $request->username;
        $user->s_name = $request->s_name;
        $user->l_name = $request->l_name;
        $user->fio = $request->s_name.' '.$request->username.' '.$request->l_name;
        $user->email = $request->email;
        $user->real_password = $request->real_password;
        $password = Hash('sha1', $request->real_password);
        $user->password = $password;
        $user->rep_pass = $password;
        $user->brithday = $request->brithday;
        $user->tel_num = $request->tel_num;
        $user->balance = $request->balance;
        $user->bonus = $request->bonus;
        $user->pol_id = $request->pol_id;
        $user->user_status_id = $request->user_status_id;
        $user->created_at = time();
        $user->updated_at = time();

        if($request->admin) $user->admin = 1;
        else $user->admin = 0;
        return $user;
    }

    public function save($user, $request){
        $user = $this->handle($user, $request);
        return $user->save();
    }
}
