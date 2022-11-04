<?php

namespace App\Http\Requests\Admin\Olimpiada;

use Illuminate\Foundation\Http\FormRequest;

class OlimpiadaOptionQuestionSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'surak' => 'required',
            'zhauaptar.*.variant' => 'required',
        ];
    }
}
