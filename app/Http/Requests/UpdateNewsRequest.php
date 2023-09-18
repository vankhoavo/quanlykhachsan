<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'            => 'required|exists:news,id',
            'tieu_de'       => 'required|min:5|max:100',
            'slug'          => 'required|min:5|max:100',
            'mo_ta'         => 'required|min:10|max:500',
            'noi_dung'      => 'required|min:10',
            'is_open'       => 'required|boolean',
            'hinh_anh'      => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id.*'          => 'Tin tức không tồn tại',
            'tieu_de.*'     => 'Tiêu đề phải từ 5 đến 10 ký tự',
            'slug.*'        => 'Slug phải từ 5 đến 10 ký tự',
            'mo_ta.*'       => 'Mô tả phải từ 10 đến 500 ký tự',
            'noi_dung.*'    => 'Nội dung ít nhất phải 10 ký tự',
            'is_open.*'     => 'Tình trạng chỉ được chọn theo yêu cầu',
            'hinh_anh.*'    => 'Hình ảnh không được để trống',
        ];
    }
}
