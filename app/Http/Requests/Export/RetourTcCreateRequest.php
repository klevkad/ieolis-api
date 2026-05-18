<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class RetourTcCreateRequest extends FormRequest
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
            'bon_appro_cam' => 'present',
            'bon_appro_clip' => 'present',
            'compteur_sorti_cam' => 'present',
            'dateh_sorti_cam' => 'Date',
            'idcamion' => 'exists:parc.ENGIN,IDENGIN',
            'idchauffeur' => 'exists:booking.CHAUFFEUR,IDCHAUFFEUR',
            'idclipon' => 'exists:parc.ENGIN,IDENGIN',
            'idlieu_appro_cam' => $this->idlieu_appro_cam == '' ? 'present' : 'exists:booking.LIEU_APPRO,IDLIEU_APPRO',
            'idlieu_appro_clip' => $this->idlieu_appro_clip == '' ? 'present' : 'exists:booking.LIEU_APPRO,IDLIEU_APPRO',
            'idpositionnement' => 'exists:booking.POSITIONNEMENT_TC,IDPOSITIONNEMENT',
            'idremorque' => 'exists:parc.ENGIN,IDENGIN',
            'idtransporteur' => 'exists:booking.TRANSPORTEUR,IDTRANSPORTEUR',
            'num_plom_tc' => 'present',
            'qte_appro_cam' => 'present',
            'qte_appro_clip' => 'present',
        ];
    }
}
