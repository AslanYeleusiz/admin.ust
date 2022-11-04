<?php

namespace App\Http\Requests\Api\V1\Turnir;

use Illuminate\Foundation\Http\FormRequest;

class TurnirZhetekshiRequest extends FormRequest
{

    public function rules()
    {
        return [
            'zhetekshi_name' => 'required'
        ];
    }
}
