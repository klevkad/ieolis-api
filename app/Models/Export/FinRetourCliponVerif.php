<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinRetourCliponVerif extends Model
{
    use HasFactory;

    protected $table = 'fin_retour_clipon_verif';
    protected $primaryKey = 'idretour_conteneur';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'cadenas1',
        'cadenas2',
        'cadenas3',
        'flexible1',
        'flexible2',
        'niv_carburant'
    ];

    public function attributioncliponretour()
    {
        return $this->hasOne('App\Models\Export\AttributionCliponRetour', 'idretour_conteneur', 'idretour_conteneur');
    }

    public function retourcliponverif()
    {
        return $this->belongsTo('App\Models\Export\RetourCliponVerif','idretour_conteneur','idretour_conteneur');
    }

    public function finretour()
    {
        return $this->belongsTo('App\Models\Export\FinRetourTc','idretour_conteneur','idretour_conteneur');
    }

    public function retourtc()
    {
        return $this->hasOne('App\Models\Export\RetourTC','idretour_conteneur','idretour_conteneur');
    }
}
