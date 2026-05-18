<?php

namespace App\Http\Requests\Fichiers;

use Illuminate\Foundation\Http\FormRequest;

class ChauffeurUpdateRequest extends FormRequest
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
            'idtransporteur' => 'required', 
            'nom_chauffeur' => 'required', 
            'prenom_chauffeur' => 'required', 
            'no_pc' => 'required|unique:booking.CHAUFFEUR,no_pc,'.$this->id.',idchauffeur', 
            'tel_mob' => 'present',
        ];
    }
}
