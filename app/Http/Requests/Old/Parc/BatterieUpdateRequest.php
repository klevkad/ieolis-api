<?php

namespace App\Http\Requests\Old\Parc;

use Illuminate\Foundation\Http\FormRequest;

class BatterieUpdateRequest extends FormRequest
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
            'libelle' => 'required|unique:parc.batteries,libelle,'.$this->id.',id', 
            'acquisition' => $this->acquisition ? 'date' : '',
            'batterieetat_id' => 'required|exists:parc.batterieetats,id',
            'batterietype_id' => 'required|exists:parc.batterieetats,id',
            'capacite' => 'required|max:10',
            'codetype' => 'required|exists:parc.typengin,codetype',
            'enabled' => 'boolean',
            'tension' => 'required|numeric',
        ];
    }
}
