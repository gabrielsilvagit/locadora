<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DropOffRequest extends FormRequest
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
            'damage' => 'required',
            'damage_notes' => 'required',
            'clean'=> 'required',
            'clean_notes' => 'required',
            'fuel_level' => 'required',
            'current_km' => 'required',
            'rental_id' => 'required'
        ];
    }
}
