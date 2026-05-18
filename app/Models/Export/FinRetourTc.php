<?php

namespace App\Models\Export;

use App\Models\Engins\ApproCarburant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinRetourTc extends Model
{
    use HasFactory;

    protected $table = 'fin_retour_tc';
    protected $primaryKey = 'idfin_retour_tc';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';
/*
*/
    const CREATED_AT = 'dateh_saisie';
    const UPDATED_AT = 'dateh_modif';

    protected $fillable = [
        'dateh_arrive_cam', 
        'compteur_arriv_cam', 
        'qte_appro_arrive_cam', 
        'qte_appro_arrive_clipon', 
        'idretour_conteneur', 
        'idlieu_appro_cli_arr', 
        'idlieu_appro_cam', 
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
        return $this->hasOne('App\Models\Export\FinRetourCliponVerif','idretour_conteneur','idretour_conteneur');
    }

    public function retourcliponverif()
    {
        return $this->hasOne('App\Models\Export\RetourCliponVerif','idretour_conteneur','idretour_conteneur');
    }

    public function embarquement_tc()
    {
        return $this->hasOne('App\Models\Export\EmbarquementTc','idretour_conteneur','idretour_conteneur');
    }

    public function retourtc()
    {
        return $this->belongsTo('App\Models\Export\RetourTc','idretour_conteneur','idretour_conteneur');
    }

    public function lieuapproclipon()
    {
        return $this->belongsTo('App\Models\Fichiers\LieuAppro','idlieu_appro_cli_arr','idlieu_appro');
    }

    public function lieuapprocamion()
    {
        return $this->belongsTo('App\Models\Fichiers\LieuAppro','idlieu_appro_cam','idlieu_appro');
    }

    public function agenttransport()
    {
        return $this->belongsTo('App\Models\Old\Eolis\Username','agent_trans','codeuser');
    }

    public function sorties()
    {
        return $this->belongsToMany('App\Models\Old\Parc\Sortie', 'sortie_fin_retour_tc', 'idfin_retour_tc', 'idsortie');
    }

    public function sorties2()
    {
        return $this->belongsToMany('App\Models\Export\Sortie_AttributionFinRetour', 'sortie_fin_retour_tc', 'idfin_retour_tc', 'idsortie');
    }

    public function sortiesfinretourtc()
    {
        return $this->hasMany('App\Models\Export\SortieFinRetourTc', 'idfin_retour_tc');
    }
}

class SortieFinRetourTc extends Model
{
    protected $table = 'sortie_fin_retour_tc';
    protected $primaryKey = 'idfin_retour_tc';
    public $incrementing = true;
    public $timestamps = false;

    public function sortie()
    {
        return $this->hasOne('App\Models\Old\Parc\Sortie', 'idbon', 'idsortie');
    }
}
