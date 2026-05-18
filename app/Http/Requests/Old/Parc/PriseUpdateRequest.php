<?php

namespace App\Http\Requests\Old\Parc;

use Illuminate\Foundation\Http\FormRequest;

class PriseUpdateRequest extends FormRequest
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
            'libelle' => 'required|unique:parc.prises,libelle,'.$this->id.',id', 
        ];
    }
}
