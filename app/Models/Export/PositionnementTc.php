<?php

namespace App\Models\Export;

use App\Models\Engins\ApproCarburant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionnementTc extends Model
{
    use HasFactory;

    protected $table = 'positionnement_tc';
    protected $primaryKey = 'idpositionnement';
    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'booking';
/*
*/
    const CREATED_AT = 'dateh_saisie';
    const UPDATED_AT = 'dateh_modif';

    protected $fillable = [
        'dateh_depart',
        'idtransporteur',
        'idchauffeur',
        'idcamion',
        'idremorque',
        'compteur_depart',
        'intrant',
        'qte_appro',
        'idactivites',
        'idlieu_depart',
        'idlieu_arrive',
        'idattribution_tc',
        'idlieu_appro'
    ];

    protected $with = [
        'camion',
        'remorque',
        'approcarburant'
    ];

    public function approcarburant()
    {
        return $this->morphOne(ApproCarburant::class, 'model');
    }

    public function attributioncliponverif()
    {
        return $this->hasOne('App\Models\Export\AttributionCliponVerif','idattribution_tc','idattribution_tc');
    }

    public function finpositcliponverif()
    {
        return $this->hasOne('App\Models\Export\FinPositCliponVerif','idpositionnement','idpositionnement');
    }

    public function attributiontc()
    {
        return $this->belongsTo('App\Models\Export\AttributionTC','idattribution_tc','idattribution_tc');
    }

    public function lieuarrivee()
    {
        return $this->belongsTo('App\Models\Old\Eolis\Port','idlieu_arrive','codeport');
    }

    public function stations()
    {
        return $this->hasMany('App\Models\Fichiers\StationEmpotage','idlieu','idlieu_arrive');
    }

    public function portdep()
	{
		return $this->belongsTo('App\Models\Old\Eolis\Port','idlieu_depart','codeport');
	}

    public function portarr()
	{
		return $this->belongsTo('App\Models\Old\Eolis\Port','idlieu_arrive','codeport');
	}

    public function transporteur()
    {
        return $this->belongsTo('App\Models\Fichiers\Transporteur','idtransporteur','idtransporteur');
    }

    public function chauffeur()
    {
        return $this->belongsTo('App\Models\Fichiers\Chauffeur','idchauffeur','idchauffeur');
    }

    public function lieuappro()
    {
        return $this->belongsTo('App\Models\Fichiers\LieuAppro','idlieu_appro','idlieu_appro');
    }

    public function empotagetc()
    {
        return $this->hasOne('App\Models\Export\EmpotageTCPosit','idpositionnement','idpositionnement');
    }

    public function finposit()
    {
        return $this->hasOne('App\Models\Export\FinPositTC','idpositionnement','idpositionnement');
    }

    public function retourtc()
    {
        return $this->hasOne('App\Models\Export\RetourTC','idpositionnement','idpositionnement');
    }

    public function camion()
    {
        return $this->belongsTo('App\Models\Old\Parc\Engin', 'idcamion', 'idengin');
    }

    public function remorque()
    {
        return $this->belongsTo('App\Models\Old\Parc\Engin', 'idremorque', 'idengin');
    }

    public function ordredetransports()
    {
        return $this->belongsToMany('App\Models\Old\Parc\OT', 'OT_positionnement_tc', 'idot', 'idpositionnement');
    }

    public function sorties()
    {
        return $this->belongsToMany('App\Models\Old\Parc\Sortie', 'bon_PHYSIQUE', 'idpositionnement', 'idsortie');
    }

    public function sorties2()
    {
        return $this->belongsToMany('App\Models\Export\Sortie_AttributionPosit', 'bon_PHYSIQUE', 'idpositionnement', 'idsortie');
    }

    public function bonphysique()
    {
        return $this->hasOne('App\Models\Export\BonPhysique', 'idpositionnement');
    }
}


class BonPhysique extends Model
{
    protected $table = 'bon_physique';
    protected $primaryKey = 'idpositionnement';
    public $incrementing = true;
    public $timestamps = false;

    public function sortie()
    {
        return $this->hasOne('App\Models\Old\Parc\Sortie', 'idbon', 'idsortie');
    }
}
