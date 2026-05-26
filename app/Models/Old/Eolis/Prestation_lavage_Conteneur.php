<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestation_lavage_Conteneur extends Model
{
    use HasFactory;

    protected $table = 'prestation_lavage_conteneur';
    protected $primaryKey = 'id_prestation_lav';
    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'eolis';
    

    protected $fillable = ['no_tc','username','observation','date_lavage','idengin','app','laveur','created_at','updated_at'];

    public function tcs_base()
    {
        return $this->hasOne('App\Models\Old\Eolis\TcsBase', 'no_tc', 'no_tc'/*'codeport'*/);
    }
}