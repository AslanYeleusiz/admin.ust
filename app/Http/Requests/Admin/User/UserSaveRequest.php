<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserSaveRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required|max:30',
            's_name' => 'required|max:30',
            'l_name' => 'required|max:30',
            'email' => 'required|email|unique:user,email,',
            'tel_num' => 'required|unique:user,tel_num',
            'real_password' => 'required|max:30',
            'user_status_id' => 'required',
        ];
    }
}
