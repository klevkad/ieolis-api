<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class FinPositTcUpdateRequest extends FormRequest
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
            'compteur_arriv' => 'present',
            'confirm_intrant' => 'Boolean',
            'dateh_arrive' => 'Date',
        ];
    }
}
