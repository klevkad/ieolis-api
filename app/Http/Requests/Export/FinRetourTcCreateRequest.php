<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class FinRetourTcCreateRequest extends FormRequest
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
            'appro_cam' => 'Boolean',
            'appro_cli' => 'Boolean',
            'compteur_arriv_cam' => 'present',
            'dateh_arrive_cam' => 'Date',
            'idboncam' => 'required_if:appro_cam,true,exists:parc.SORTIE,IDBON',
            'idboncli' => 'required_if:appro_cli,true,exists:parc.SORTIE,IDBON',
            'idlieu_appro_cam' => 'required_if:appro_cam,true,exists:booking.LIEU_APPRO,IDLIEU_APPRO',
            'idlieu_appro_cli_arr' => 'required_if:appro_cli,true,exists:booking.LIEU_APPRO,IDLIEU_APPRO',
            'idretour_conteneur' => 'exists:booking.RETOUR_CONTENEUR,IDRETOUR_CONTENEUR',
            'qte_appro_arrive_cam' => 'required_if:appro_cam,true,Min:0',
            'qte_appro_arrive_clipon' => 'required_if:appro_cli,true,Min:0',
        ];
    }
}
