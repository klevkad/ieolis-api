<?php

namespace App\Models\Export;

use App\Models\Engins\ApproCarburant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributionClipon extends Model
{
    use HasFactory;

    protected $table = 'attribution_clipon';
    protected $primaryKey = 'idattribution_tc';
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'idattribution_tc',
        'idclipon',
        'qte_appro',
        'idlieu_appro'
    ];

    protected $with = [
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

    public function attributiontc()
    {
        return $this->belongsTo('App\Models\Export\AttributionTC','idattribution_tc','idattribution_tc');
    }
    
    public function positionnementtc()
    {
        return $this->hasOne('App\Models\Export\PositionnementTC','idattribution_tc','idattribution_tc');
    }

    public function clipon()
    {
        return $this->belongsTo('App\Models\Old\Parc\Engin','idclipon','idengin');
    }

    public function lieuappro()
    {
        return $this->belongsTo('App\Models\Fichiers\LieuAppro','idlieu_appro','idlieu_appro');
    }

    public function sorties()
    {
        return $this->belongsToMany('App\Models\Old\Parc\Sortie', 'sortie_attribution_clipon', 'idattribution_tc', 'idsortie');
    }

    public function sorties2()
    {
        return $this->belongsToMany('App\Models\Export\Sortie_AttributionClipon', 'sortie_attribution_clipon', 'idattribution_tc', 'idsortie');
    }
}
