<?php

namespace App\Http\Requests\Admin\Material;

use Illuminate\Foundation\Http\FormRequest;

class MaterialSkidkaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'skidka' => 'required|numeric|between:1,100',
            'from_date' => 'required',
            'to_date' => 'required',
        ];
    }
}
