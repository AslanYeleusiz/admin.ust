<?php

namespace App\Http\Requests\Api\V1\Olimpiada;

use Illuminate\Foundation\Http\FormRequest;

class OlimpiadaAppealsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'variable' => 'required'
        ];
    }
}
