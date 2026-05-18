<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetourTcPropreMoyen extends Model
{
    use HasFactory;

    protected $table = 'retour_tc_propre_moy';
    protected $primaryKey = 'idretour_tc';
    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'booking';
/*
*/
    const CREATED_AT = 'dateh_saisi';
    const UPDATED_AT = 'dateh_modif';

    protected $fillable = [
        'idattribution_tc',
        'immat_camion',
        'immat_remorque',
        'nom_chauffeur',
        'prenom_chauffeur',
        'num_pc',
        'transporteur',
        'dateh_retour',
        'num_plom_tc',
        'user_saisi',
        'user_modif'
    ];

    public function positionnement()
    {
        return $this->belongsTo('App\Models\Export\PositionnementTcPropreMoyen','idattribution_tc','idattribution_tc');
    }

    public function embarquementtc()
    {
        return $this->hasOne('App\Models\Export\EmbarquementTc','idretour_conteneur','idretour_tc');
    }
}
