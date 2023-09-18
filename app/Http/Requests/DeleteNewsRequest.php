<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteNewsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'            => 'required|exists:news,id',
        ];
    }

    public function messages()
    {
        return [
            'id.*'          => 'Tin tức không tồn tại',
        ];
    }
}
