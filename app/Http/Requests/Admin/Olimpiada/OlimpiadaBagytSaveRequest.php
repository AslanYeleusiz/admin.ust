<?php

namespace App\Http\Requests\Admin\Olimpiada;

use Illuminate\Foundation\Http\FormRequest;

class OlimpiadaBagytSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'o_bagyty' => 'required',
            'bagyt' => 'required',
            'type_ids' => 'required',
            'o_katysushy_idd' => 'required',
        ];
    }
}
