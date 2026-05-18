<?php

namespace App\Models\Export;

use App\Models\Engins\ApproCarburant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributionCliponRetour extends Model
{
    use HasFactory;

    protected $table = 'attribution_clipon_retour';
    protected $primaryKey = 'idretour_conteneur';
    public $timestamps = false;
    public $incrementing = false;
    protected $connection = 'booking';

    protected $fillable = [
        'idretour_conteneur',
        'idclipon',
        'qte_appro_clip',
        'idlieu_appro_clip',
        'bon_appro_clip',
        'dateh_arret_clip'
    ];

    protected $with = [
        'approcarburant'
    ];

    public function approcarburant()
    {
        return $this->morphOne(ApproCarburant::class, 'model');
    }

    public function finretourcliponverif()
    {
        return $this->hasOne( 'App\Models\Export\FinRetourCliponVerif', 'idretour_conteneur', 'idretour_conteneur' );
    }

    public function attributioncliponretourverif()
    {
        return $this->hasOne( 'App\Models\Export\AttributionCliponRetourVerif', 'idretour_conteneur', 'idretour_conteneur' );
    }

    public function retourtc()
    {
        return $this->belongsTo('App\Models\Export\RetourTC','idretour_conteneur','idretour_conteneur');
    }

    public function finretour()
    {
        return $this->hasOne('App\Models\Export\FinRetourTC','idretour_conteneur','idretour_conteneur');
    }

    public function clipon()
    {
        return $this->belongsTo('App\Models\Old\Parc\Engin','idclipon','idengin');
    }
    
    public function lieuapproclipon()
    {
        return $this->belongsTo('App\Models\Fichiers\LieuAppro','idlieu_appro_clip','idlieu_appro');
    }
}
