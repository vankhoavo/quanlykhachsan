<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerBookingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "booking-name"      => 'required|min:5',
            "booking-email"     => 'required|email',
            "booking-roomtype"  => 'required|exists:phongs,id',
            "booking-date"      => 'nullable',
            "booking-adults"    => 'required|min:1',
            "booking-children"  => 'nullable',
            // "booking-from"      => 'required|date|after_or_equal:' . date('Y-m-d'),
            // "booking-to"        => 'required|date|after_or_equal:booking-from',
            // "booking-room"      => 'required|numeric|min:1',
        ];
    }
}
