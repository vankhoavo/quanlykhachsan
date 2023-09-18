<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ho_va_ten'         => 'required|min:5|max:50',
            'email'             => 'required|email|unique:admins,email',
            'password'          => 'required|min:6|max:30',
            'ag_password'       => 'required|same:password',
            'so_dien_thoai'     => 'required|digits:10|unique:admins,so_dien_thoai',
            'is_master'         => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'so_dien_thoai.*'   => 'Số điện thoại chỉ 10 chữ số!',
        ];
    }
}
