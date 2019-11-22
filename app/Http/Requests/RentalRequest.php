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
            'user_id' => 'sometimes|required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'current_km'=>'sometimes|required|integer|min:0',
            'fuel_level'=>'sometimes|required|integer|max:8|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'notes' => 'string',
            'free_km' => 'required|boolean',
            'under_25' => 'required|boolean'
        ];
    }
}
