<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
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
            'id'   => 'required|exists:reviews,id',
            'name' => 'required|min:5',
            'city'=> 'required',
            'rate'=> 'required|numeric|min:1|max:5',
            'content'=> 'required',
            'avatar'=> 'required',
        ];
    }
}
