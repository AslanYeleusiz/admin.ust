<?php

namespace App\Http\Requests\Api\V1\Material;

use Illuminate\Foundation\Http\FormRequest;

class MaterialZharialauRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string|max:255',
            'file_doc' => 'required',
            'work' => 'required|string',
            'zhanr' => 'required',
            'zhanr2' => 'required',
            'zhanr3' => 'required',
        ];
    }
}
