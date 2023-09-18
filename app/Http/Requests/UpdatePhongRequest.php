<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhongRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'            =>  'required|exists:phongs,id',
            'ma_phong'      =>  'required|unique:phongs,id',
            'gia_mac_dinh'  =>  'required|numeric|min:0',
            'mo_ta_phong'   =>  'required',
            'tinh_trang'    =>  'required|numeric|min:0|max:2',
            'hinh_anh'      =>  'required',
            'khu_vuc_id'    =>  'required|exists:khu_vucs,id',
            'so_khach'      =>  'required|numeric|min:1|max:6',
        ];
    }

    public function messages()
    {
        return [
            'id.*'                      => 'Mã phòng không tồn tại',
            'ma_phong.required'         => 'Mã phòng yêu cầu phải nhập',
            'gia_mac_dinh.required'     => 'Giá mặc định yêu cầu phải nhập',
            'mo_ta_phong.required'      => 'Mô tả phòng yêu cầu phải nhập',
            'tinh_trang.required'       => 'Tình trạng yêu cầu phải nhập',
            'hinh_anh.required'         => 'Hình ảnh yêu cầu phải nhập',
            'khu_vuc_id.required'       => 'Khu vực yêu cầu phải nhập',
            'ma_phong.unique'           => 'Mã phòng đã tồn tại',
            'gia_mac_dinh.numeric'      => 'Giá mặc định phải là số',
            'gia_mac_dinh.min'          => 'Giá mặc định tối thiểu phải 100.000đ',
            'tinh_trang.*'              => 'Tình trạng phải chọn trong option',
            'so_khach.*'                => 'Số khách phải lớn hơn 1',
            'khu_vuc_id.exists'         => 'Khu vực không tồn tại',
        ];
    }
}
