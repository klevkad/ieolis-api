<?php

namespace App\Http\Requests\Engins;

use Illuminate\Foundation\Http\FormRequest;

class SuiviKmCreateRequest extends FormRequest
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
            'curdate' => 'Date',
//            'prevdate' => 'Date',
            'cptkm' => 'Numeric|min:0',
            'nbrtcv' => 'Numeric|min:0',
            'nbrtcp' => 'Numeric|min:0',
            'qtecarb' => 'Numeric|min:0',
            'nbrhrtrav' => 'Numeric|min:0',
        ];
    }
}
