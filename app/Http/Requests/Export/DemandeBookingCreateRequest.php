<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class DemandeBookingCreateRequest extends FormRequest
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
            'date_demande' => 'required|date',
            'setpoint' => 'required|Numeric|min:1',
            'volet' => 'required|Numeric|min:0',
            'si_transporteur_eolis' => 'required',
			'payeurfret' => 'required|exists:compta.F_COMPTET,CT_Num',
            'date_posit_souhait' => 'required|after:"'.substr($this->date_demande, 0, 10).'"',
            'produit' => 'required|exists:eolis.produit,produit',
            'noescale' => 'required|exists:eolis.escale,noescale',
            'idlieu_arrive' => 'required|exists:eolis.port,codeport',
            'idtransporteur' => 'required|exists:booking.transporteur,idtransporteur',
            'nb_tcs' => 'required|Numeric|min:1'
        ];
    }
}
