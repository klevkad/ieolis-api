<?php

namespace App\Http\Requests\Fichiers;

use Illuminate\Foundation\Http\FormRequest;

class StationEmpotageCreateRequest extends FormRequest
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
            'codestation_empotage' => 'unique:booking.STATION_EMPOTAGE,codestation_empotage',
            'lib_station' => 'present',
            'idlieu' => 'exists:eolis.PORT,codeport',
        ];
    }
}
