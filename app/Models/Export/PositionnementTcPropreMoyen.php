<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionnementTcPropreMoyen extends Model
{
    use HasFactory;

    protected $table = 'posit_propre_moy';
    protected $primaryKey = 'idattribution_tc';
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
        'dateh_sortie', 
        'user_saisi', 
        'user_modif'
    ];


    public function attributiontc()
    {
        return $this->belongsTo('App\Models\Export\AttributionTc','idattribution_tc','idattribution_tc');
    }

    public function retourtc()
    {
        return $this->hasOne('App\Models\Export\RetourTcPropreMoyen','idattribution_tc','idattribution_tc');
    }
}
