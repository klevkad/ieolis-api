<?php

namespace App\Models\Export;

use App\Models\Engins\ApproCarburant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetourTc extends Model
{
    use HasFactory;

    protected $table = 'retour_conteneur';
    protected $primaryKey = 'idretour_conteneur';
    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'booking';
/*
*/
    const CREATED_AT = 'dateh_saisie';
    const UPDATED_AT = 'dateh_modif';

    protected $fillable = [
        'idremorque',
        'idcamion',
        'idchauffeur',
        'idtransporteur',
        'idpositionnement',
        'qte_appro_cam',
        'dateh_sorti_cam',
        'compteur_sorti_cam',
        'num_plom_tc',
        'idlieu_appro_cam',
        'bon_appro_cam'
    ];

    protected $with = [
        'approcarburant'
    ];

    public function approcarburant()
    {
        return $this->morphOne(ApproCarburant::class, 'model');
    }

    public function attributioncliponretourverif()
    {
        return $this->hasOne('App\Models\Export\AttributionCliponRetourVerif','idretour_conteneur','idretour_conteneur');
    }

    public function finretourcliponverif()
    {
        return $this->hasOne('App\Models\Export\FinRetourCliponVerif','idretour_conteneur','idretour_conteneur');
    }

    public function retourcliponverif()
    {
        return $this->hasOne('App\Models\Export\AttributionCliponRetourVerif','idretour_conteneur','idretour_conteneur');
    }
   
    public function attributionclipon()
    {
        return $this->hasOne('App\Models\Export\AttributionCliponRetour','idretour_conteneur','idretour_conteneur');
    }

    public function lieuapprocamion()
    {
        return $this->belongsTo('App\Models\Fichiers\LieuAppro','idlieu_appro_cam','idlieu_appro');
    }

    public function transporteur()
    {
        return $this->belongsTo('App\Models\Fichiers\Transporteur','idtransporteur','idtransporteur');
    }

    public function camion()
    {
        return $this->belongsTo('App\Models\Old\Parc\Engin', 'idcamion', 'idengin');
    }

    public function remorque()
    {
        return $this->belongsTo('App\Models\Old\Parc\Engin', 'idremorque', 'idengin');
    }

    public function chauffeur()
    {
        return $this->belongsTo('App\Models\Fichiers\Chauffeur','idchauffeur','idchauffeur');
    }

    public function embarquementtc()
    {
        return $this->hasOne('App\Models\Export\EmbarquementTC','idretour_conteneur','idretour_conteneur');
    }

    public function empotagetc()
    {
        return $this->hasOne('App\Models\Export\EmpotageTCPosit','idpositionnement','idpositionnement');
    }

    public function positionnement()
    {
        return $this->belongsTo('App\Models\Export\PositionnementTC','idpositionnement','idpositionnement');
    }

    public function finposit()
    {
        return $this->hasOne('App\Models\Export\FinPositTC','idpositionnement','idpositionnement');
    }

    public function finretour()
    {
        return $this->hasOne('App\Models\Export\FinRetourTC','idretour_conteneur','idretour_conteneur');
    }

    public function sorties()
    {
        return $this->belongsToMany('App\Models\Old\Parc\Sortie', 'sortie_retour_conteneur', 'idretour_conteneur', 'idsortie');
    }
}
