<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class IncidentUpdateRequest extends FormRequest
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
            'nobooking' => 'exists:booking.P_DEMANDE_BOOKING,NO_BOOKING',
            'no_tc' => 'exists:eolis.TCS_BASE,NO_TC',
            'type_incident_id' => 'exists:booking.TYPE_INCIDENTS,ID',
            'codetype' => 'exists:parc.TYPENGIN,CODETYPE',
            'commentaire' => 'present',
            'act' => 'integer|min:0',
//            'old_data' => '',
        ];
    }
}
