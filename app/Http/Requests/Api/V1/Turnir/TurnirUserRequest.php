<?php

namespace App\Http\Requests\Api\V1\Turnir;

use Illuminate\Foundation\Http\FormRequest;

class TurnirUserRequest extends FormRequest
{

    public function rules()
    {
        return [
            'fio_user' => 'required'
        ];
    }

}
