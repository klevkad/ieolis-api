<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class ReAttributionTcRequest extends FormRequest
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
            'attrib1' => 'required|exists:booking.ATTRIBUTION_TC,idattribution_tc',
            'attrib2' => 'required_if:option,1|exists:booking.ATTRIBUTION_TC,idattribution_tc',
            'no_booking1' => 'required|exists:booking.P_DEMANDE_BOOKING,no_booking',
            'no_booking2' => 'required|exists:booking.P_DEMANDE_BOOKING,no_booking',/**/
        ];
    }
}
