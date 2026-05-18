<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributionCliponRetourVerif extends Model
{
    use HasFactory;

    protected $table = 'attribution_clipon_ret_verif';
    protected $primaryKey = 'idretour_conteneur';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'idretour_conteneur',
        'cadenas1',
        'cadenas2',
        'cadenas3',
        'flexible1',
        'flexible2'
    ];

    public function attributioncliponretour()
    {
        return $this->belongsTo( 'App\Models\Export\AttributionCliponRetour', 'idretour_conteneur', 'idretour_conteneur' );
    }

    public function finretourcliponverif()
    {
        return $this->hasOne('App\Models\Export\FinRetourCliponVerif', 'idretour_conteneur', 'idretour_conteneur');
    }

    public function finretour()
    {
        return $this->hasOne('App\Models\Export\FinRetourTc', 'idretour_conteneur', 'idretour_conteneur');
    }

    public function retourtc()
    {
        return $this->belongsTo('App\Models\Export\RetourTc', 'idretour_conteneur', 'idretour_conteneur');
    }
}
