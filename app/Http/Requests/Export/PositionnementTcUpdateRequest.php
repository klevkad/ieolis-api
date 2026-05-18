<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class PositionnementTcUpdateRequest extends FormRequest
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
            'compteur_depart' => $this->compteur_depart == '' ? 'present' : 'present|Numeric',
            'dateh_depart' => 'required|Date',
            'idcamion' => 'required|exists:parc.ENGIN,idengin',
            'idchauffeur' => 'required|exists:booking.CHAUFFEUR,idchauffeur',
            'idlieu_appro' => $this->idlieu_appro == '' ? 'present' : 'present|exists:booking.LIEU_APPRO,idlieu_appro',
            'idlieu_arrive' => 'required|exists:eolis.PORT,codeport',
            'idlieu_depart' => 'required|exists:eolis.PORT,codeport',
            'idremorque' => 'required|exists:parc.ENGIN,idengin',
            'idtransporteur' => 'required|exists:booking.TRANSPORTEUR,idtransporteur',
            'intrant' => 'required|Boolean',
            'qte_appro' => $this->qte_appro == '' ? 'present' : 'present|Numeric',
        ];
    }
}
