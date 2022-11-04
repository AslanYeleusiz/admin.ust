<?php

namespace App\Http\Requests\Api\V1\Olimpiada;

use Illuminate\Foundation\Http\FormRequest;

class OlimpiadaUserRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required|max:80'
        ];
    }
}
