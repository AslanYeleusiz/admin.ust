<?php

namespace App\Http\Requests\Admin\Qmg;

use Illuminate\Foundation\Http\FormRequest;

class QmgBolimSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'date' => 'required',
            'synyp_text' => 'required',
            'sub_id' => 'required',
            'path' => 'required',
        ];
    }
}
