<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckOutRequest extends FormRequest
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
            'rental_id' => 'required|exists:rentals,id',
            'plate' => 'required|exists:vehicles,plate',
            'current_km'=>'sometimes|required|integer|min:0',
            'fuel_level'=>'sometimes|required|integer|max:8|min:0',
            'category_id'=>'sometimes|required|exists:categories,id'
        ];
    }
}
