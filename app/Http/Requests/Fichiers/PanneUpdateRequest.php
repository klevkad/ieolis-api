<?php

namespace App\Http\Requests\Fichiers;

use Illuminate\Foundation\Http\FormRequest;

class PanneUpdateRequest extends FormRequest
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
            'lib_panne' => 'required|unique:booking.PANNES,lib_panne,'.$this->id.',idpanne',
            'typengins' => 'required|array'
        ];
    }
}
