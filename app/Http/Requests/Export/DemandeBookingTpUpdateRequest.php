<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class DemandeBookingTpUpdateRequest extends FormRequest
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
            'date_posit_souhait' => 'required|date',
            'eta' => 'required|date',
//            'file' => 'required|file|mimes:pdf',
            'idlieu_arrive' => 'required|exists:eolis.port,codeport',
            'idlieu_depart' => 'required|exists:eolis.port,codeport',
            'navire' => 'required',
            'no_booking' => 'required',
            'noescale' => 'required',
            'nom_acconier' => 'required',
            'produit' => 'required|exists:eolis.produit,produit',
            'setpoint' => 'required|Numeric|min:1',
            'volet' => 'required|Numeric|min:0',
        ];
    }
}
