<?php

namespace App\Http\Requests\Salon;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
//            'name' => 'string|max:255',
//            'latitude' => 'required|between:-90,90',
//            'longitude' => 'required|between:-180,180'
        ];
    }
}
