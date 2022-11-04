<?php

namespace App\Http\Requests\Admin\Turnir;

use Illuminate\Foundation\Http\FormRequest;

class TurnirSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'category' => 'required',
            'month' => 'required',
            'price' => 'required',
            'old_price' => 'required',
            'rate' => 'required',
        ];
    }
}
