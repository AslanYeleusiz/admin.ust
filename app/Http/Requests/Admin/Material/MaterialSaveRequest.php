<?php

namespace App\Http\Requests\Admin\Material;

use Illuminate\Foundation\Http\FormRequest;

class MaterialSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:3',
            'description' => 'required|string|min:3',
            'filename' => 'required',
            'zhanr' => 'required',
            'zhanr2' => 'required',
            'zhanr3' => 'required',
            'user_id' => 'required',
            'date' => 'required',
            'sell' => 'required',
            'likes' => 'required',
            'dislikes' => 'required',
        ];
    }
}
