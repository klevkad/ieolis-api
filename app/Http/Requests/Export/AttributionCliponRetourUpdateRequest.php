<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class AttributionCliponRetourUpdateRequest extends FormRequest
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
            'dateh_arret_clip' => $this->dateh_arret_clip ? 'Date' : 'present',
        ];
    }
}
