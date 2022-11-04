<?php

namespace App\Http\Requests\Admin\Qmg;

use Illuminate\Foundation\Http\FormRequest;

class QmgSubjectSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:128'
        ];
    }
}
