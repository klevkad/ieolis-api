<?php

namespace App\Models\Export;

use App\Models\Engins\ApproCarburant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinPositTc extends Model
{
    use HasFactory;

    protected $table = 'fin_posit_tc';
    protected $primaryKey = 'idfin_posit_tc';
    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'booking';
/*
*/
    const CREATED_AT = 'dateh_saisie';
    const UPDATED_AT = 'dateh_modif';

    protected $fillable = [
        'dateh_arrive',
        'compteur_arriv',
        'idpositionnement',
        'agent_com',
        'confirm_intrant',
        'codeuser_modif'
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
        return $this->hasOneThrough(
            'App\Models\Export\AttributionCliponVerif',
            'App\Models\Export\PositionnementTc',
            'idpositionnement',
            'idattribution_tc',
            'idpositionnement',
            'idpositionnement'            
        );
    }

    public function finpositcliponverif()
    {
        return $this->hasOne('App\Models\Export\FinPositCliponVerif','idpositionnement','idpositionnement');
    }

    public function positionnement()
    {
        return $this->belongsTo('App\Models\Export\PositionnementTC','idpositionnement','idpositionnement');
    }

    public function retourtc()
    {
        return $this->hasOne('App\Models\Export\RetourTC','idpositionnement','idpositionnement');
    }

    public function empotagetc()
    {
        return $this->hasOne('App\Models\Export\EmpotageTCPosit','idpositionnement','idpositionnement');
    }
}
