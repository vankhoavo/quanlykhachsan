<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateChiTietPhongRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id_phong'  => 'required|exists:phongs,id',
            'ten_phong' => 'required|min:2|unique:chi_tiet_phongs,ten_phong',
            'noi_that'  => 'required|min:5',
        ];
    }
}
