<?php

namespace App\Http\Requests\Old\Acconage;

use Illuminate\Foundation\Http\FormRequest;

class ReleveTemperatureReeferCreateRequest extends FormRequest
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
            'lib_shift' => 'required|exists:acconage.releve_shift,lib_shift',
            'return_air' => 'required|numeric',
            'supply_air' => 'required|numeric',
            'idt_opera8branch' => 'required|exists:acconage.t_opera_branch,idt_opera8branch',
        ];
    }
}
