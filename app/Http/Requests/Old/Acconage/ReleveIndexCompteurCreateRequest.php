<?php

namespace App\Http\Requests\Old\Acconage;

use Illuminate\Foundation\Http\FormRequest;

class ReleveIndexCompteurCreateRequest extends FormRequest
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
            'idt_releve_index_compteur' => 'required|exists:acconage.t_releve_index_compteur,idt_releve_index_compteur',
            'indexfin' => 'numeric|min:0',
            'numcompteur' => 'required|exists:acconage.t_compteur,numcompteur',
        ];
    }
}
