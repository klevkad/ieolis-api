<?php

namespace App\Http\Requests\Old\Parc;

use Illuminate\Foundation\Http\FormRequest;

class FinOuvertureRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check(); 
    }

    public function rules()
    {
        
        $ouvertureStation = $this->route('ouverturestation'); 

        return [
            'indexfin'    => ['required', 'numeric', 'min:0'],
            'quantitefin' => ['required', 'numeric', 'min:0'],
            'datefermeture' => ['nullable', 'date'],
        ];
    }

    public function withValidator($validator)
    {
        $ouvertureStation = $this->route('ouverturestation');

        // Ajout des validations métiers spécifiques (que vous aviez dans la fonction)
        $validator->after(function ($validator) use ($ouvertureStation) {
            
            if ($ouvertureStation->indexdebut > $this->indexfin) {
                $validator->errors()->add('indexfin', 'Index début est supérieur à l\'index fin.');
            }
            if ($ouvertureStation->index_logique != $this->indexfin && $this->indexfin-$ouvertureStation->index_logique>5) {
                $validator->errors()->add('indexfin', 'Index fin est différent de l\'index logique. Veuillez vérifier.');
            }
            // if ($ouvertureStation->quantitefin > $this->quantitedebut) {
            //     $validator->errors()->add('quantitefin', 'Quantité fin doit être supérieure à la quantité début.');
            // }
        });
    }

    public function messages()
    {
        return [
            // Les messages d'erreur seront gérés par le FormRequest
        ];
    }
}