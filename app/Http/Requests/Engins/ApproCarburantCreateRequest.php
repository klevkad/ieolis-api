<?php

namespace App\Http\Requests\Engins;

use Illuminate\Foundation\Http\FormRequest;

class ApproCarburantCreateRequest extends FormRequest
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
            'idengin' => 'exists:parc.ENGIN,IDENGIN',
            'bon_appro' => $this->bon_appro == '' ? 'present' : 'exists:parc.SORTIE,NUMBON_PHYS',
            'qte_appro' => 'present',
            'date_appro' => 'Date',
            'idlieu_appro' => $this->idlieu_appro == '' ? 'present' : 'exists:booking.LIEU_APPRO,IDLIEU_APPRO',
        ];
    }
}
