<?php

namespace App\Http\Requests\Engins;

use Illuminate\Foundation\Http\FormRequest;

class SignalPanneUpdateRequest extends FormRequest
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
            'idlieu' => 'exists:booking.R_LIEU,IDLIEU',
//            'description' => 'required',
        ];
    }
}
