<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class EmpotageTcPositUpdateRequest extends FormRequest
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
            'datehdeb_empot' => 'Date',
//            'datehfin_empot' => 'Date|after:"'.$this->datehdeb_empot.'"',
            'datehfin_empot' => $this->datehfin_empot ? 'Date|after:"'.$this->datehdeb_empot.'"' : '',
            'si_depassement_facture' => 'Boolean',
            'observation' => 'present',
        ];
    }
}
