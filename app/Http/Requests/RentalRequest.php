<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalRequest extends FormRequest
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
            'type' => 'required',
            'user_id' => 'required',
            'vehicle_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'daily_rate' => 'required',
            'notes' => 'required',
            'current_km' => 'required',
            'fuel_level' => 'required',
            'limited' => 'required',
        ];
    }
}
