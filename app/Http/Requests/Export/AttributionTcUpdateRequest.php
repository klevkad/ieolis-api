<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class AttributionTcUpdateRequest extends FormRequest
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
            'idbooking_conteneur' => 'exists:booking.booking_conteneur,idbooking_conteneur',
            'no_tc' => 'exists:eolis.tcs_base,no_tc',
            'plomb1' => 'present',//'required|distinct',
            'plomb2' => 'present',
            'idclipon' => 'required_if:radcli,1,distinct|exists:parc.engin,idengin',
            'idbon' => $this->idbon == '' ? '' : 'required_if:radcli,1,distinct|exists:parc.sortie,idbon',
            'idlieu_appro' => $this->idlieu_appro == '' ? '' : 'exists:booking.lieu_appro,idlieu_appro',
            'qte_appro' => 'required_if:radcli,1,Numeric|min:0'
        ];
    }
}
