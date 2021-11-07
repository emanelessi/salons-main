<?php

namespace App\Http\Requests\Salon;

use Illuminate\Foundation\Http\FormRequest;

class addRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'salon_id' => 'required',
            'salon_seat_id' => 'required',
        ];
    }
}
