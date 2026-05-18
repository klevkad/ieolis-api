<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestation_Conteneur_Dispo extends Model
{
    use HasFactory;

    protected $table = 'prestation_conteneur_dispo';
    protected $primaryKey = 'idprestation_conteneur_export';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'eolis';
    

    protected $fillable = ['no_tc','username', 'client','observation','date_mad','wash','date_lavage','date_ctrl_journalier','pti'];

    public function tcs_base()
    {
        return $this->hasOne('App\Models\Old\Eolis\TcsBase', 'no_tc', 'no_tc'/*'codeport'*/);
    }
}