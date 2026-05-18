<?php

namespace App\Http\Requests\Old\Acconage;

use Illuminate\Foundation\Http\FormRequest;

class ReleveIndexEauCreateRequest extends FormRequest
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
            'idt_releve_eau' => 'required|exists:acconage.t_releve_index_eau,idt_releve_eau',
            'indexfin' => 'numeric|min:0',
            'numcpteur' => 'required|exists:acconage.t_compteur_eau,numcpteur',
        ];
    }
}
