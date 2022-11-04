<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'email' => 'required|email',
            'tel_num' => 'required',
            'real_password' => 'required|max:30',
            'user_status_id' => 'required',
        ];
    }
}
