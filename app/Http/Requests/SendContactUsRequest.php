<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendContactUsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'      =>  'required',
            'email'     =>  'required|email',
            'message'   =>  'required|min:10',
        ];
    }

    public function messages()
    {
        return [
            'name.*'      =>  'Bạn nhập tên ít nhất 5 ký tự',
            'email.*'     =>  'Email yêu cầu phải nhập',
            'message.*'   =>  'Nội dung ít nhất 5 ký tự',
        ];
    }
}
