<?php

namespace App\Http\Requests\Old\Acconage;

use Illuminate\Foundation\Http\FormRequest;

class BranchementCreateRequest extends FormRequest
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
            'no_tc' => 'required|distinct|exists:eolis.tcs_base,no_tc',
            'numcompteur' => 'required|exists:acconage.t_compteur,numcompteur',
            'temp' => 'required',
            'trafic' => 'required|exists:acconage.traffic,idtraffic',
            'idt_statu_tc' => 'nullable|exists:acconage.t_statu_tc,idt_statu_tc',
        ];
    }
}
