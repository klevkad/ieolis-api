<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributionTc extends Model
{
    use HasFactory;

    protected $table = 'attribution_tc';
    protected $primaryKey = 'idattribution_tc';
    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'booking';
/*
*/
    const CREATED_AT = 'dateh_saisie';
    const UPDATED_AT = 'dateh_modif';

    protected $fillable = [
        'idbooking_conteneur',
        'no_tc',
        'plomb1',
        'plomb2',
        'codeuser_saisi',
        'codeuser_modif'
    ];

    public function bookingtc()
    {
        return $this->belongsTo('App\Models\Export\BookingTC','idbooking_conteneur','idbooking_conteneur');
    }

    public function attributionclipon()
    {
        return $this->hasOne('App\Models\Export\AttributionClipon','idattribution_tc','idattribution_tc');
    }

    public function attributioncliponverif()
    {
        return $this->hasOne('App\Models\Export\AttributionCliponVerif','idattribution_tc','idattribution_tc');
    }

    public function positionnementtc()
    {
        return $this->hasOne('App\Models\Export\PositionnementTc','idattribution_tc','idattribution_tc');
    }

    public function positionnementtcpropremoyen()
    {
        return $this->hasOne('App\Models\Export\PositionnementTcPropreMoyen','idattribution_tc','idattribution_tc');
    }

    public function retourtcpropremoyen()
    {
        return $this->hasOne('App\Models\Export\RetourTcPropreMoyen','idattribution_tc','idattribution_tc');
    }

    public function retourtc()
    {
        return $this->hasOneThrough(
            'App\Models\Export\RetourTc',
            'App\Models\Export\PositionnementTc',
            'idattribution_tc', // Foreign key on PositionnementTc table...
            'idpositionnement', // Foreign key on RetourTC table...
            'idattribution_tc', // Local key on AttributionTc table...
            'idpositionnement'  // Local key on PositionnementTc table...      
        );
    }

    public function empotagetc()
    {
        return $this->hasOneThrough(
            'App\Models\Export\EmpotageTcPosit',
            'App\Models\Export\PositionnementTc',
            'idattribution_tc', // Foreign key on PositionnementTc table...
            'idpositionnement', // Foreign key on RetourTC table...
            'idattribution_tc', // Local key on AttributionTc table...
            'idpositionnement'  // Local key on PositionnementTc table...      
        );
    }

    public function tc()
    {
        return $this->belongsTo('App\Models\Old\Eolis\TcsBase','no_tc','no_tc');
    }    

    public function saisiepar()
    {
        return $this->belongsTo('App\Models\Old\Eolis\Username','codeuser_saisi','codeuser');
    }

    public function modifiepar()
    {
        return $this->belongsTo('App\Models\Old\Eolis\Username','codeuser_modif','codeuser');
    }

    public function sorties()
    {
        return $this->belongsToMany('App\Models\Old\Parc\Sortie', 'sortie_attribution_tc', 'idattribution_tc', 'idsortie');
    }

    public function sorties2()
    {
        return $this->belongsToMany('App\Models\Export\Sortie_AttributionTc', 'sortie_attribution_tc', 'idattribution_tc', 'idsortie');
    }

    public function sortieattributiontc()
    {
        return $this->hasOne('App\Models\Export\SortieAttributionTc', 'idattribution_tc');
    }
}


class SortieAttributionTc extends Model
{
    protected $table = 'sortie_attribution_tc';
    protected $primaryKey = 'idattribution_tc';
    public $incrementing = true;
    public $timestamps = false;

    public function sortie()
    {
        return $this->hasOne('App\Models\Old\Parc\Sortie', 'idbon', 'idsortie');
    }
}
