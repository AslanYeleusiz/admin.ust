<?php

namespace App\Http\Controllers\Api\V1\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    public function change(Request $request) {
        $this->validator($request->all())->validate();
        if($request->img == 'userDefault.png' || $request->img == 'undefined')
            $img = '';
        else $img = $request->img;
        $user = Auth::guard('api')->user();
        $avatarIsChanged = $user->img1 != $request->img ? 1 : 0;
        $user->update([
            'username' => $request->username,
            'l_name' => $request->l_name,
            's_name' => $request->s_name,
            'fio' => $request->s_name.' '.$request->username.' '.$request->l_name,
            'img1' => $img
        ]);
        if($request->last_img != 'userDefault.png' && $avatarIsChanged)
            $this->deleteAvatar($request->last_img);
        return response()->json(['status'=>200]);
    }

    public function changePhoto(Request $request) {
        if($request->file()){
            $uploadedFile = $request->file('file');
            $ext = $uploadedFile->getClientOriginalExtension();
            $filename = time().rand(10,99).'.'.$ext;
            $file_doc = 'images/avatars/'.$filename;
            Storage::disk('images')->putFileAs(
                'avatars/',
                $uploadedFile,
                $filename
            );
            return response()->json([
                'img_path' => $file_doc,
                'img' => $filename
            ]);
        }
    }

    public function destroyPhoto(Request $request) {
        if($request->img == 'userDefault.png')
            return response()->json('ok');
        $filename = $request->img;
        if($filename != $request->last_img)
            $this->deleteAvatar($filename);
        return response()->json('ok');
    }



    protected function validator(array $data)
    {
        $messages = array(
            'required' => 'Бұл жол толтырылуы керек.',
            'max' => 'Бұл жол шектік :max таңбадан асып кетті.'
        );
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:64'],
            'l_name' => ['required', 'string', 'max:64'],
            's_name' => ['required', 'string', 'max:64']
        ], $messages);
    }

    protected function deleteAvatar($filename)
    {
        Storage::disk('images')->delete(
            'avatars/'.$filename
        );
    }



}
