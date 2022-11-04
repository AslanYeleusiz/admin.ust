<?php

namespace App\Http\Requests\Admin\Turnir;

use Illuminate\Foundation\Http\FormRequest;

class TurnirUserSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'fio_user' => 'required',
            'update_count' => 'required'
        ];
    }
}
