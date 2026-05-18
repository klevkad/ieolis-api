<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestation_Pti_Conteneur extends Model
{
    use HasFactory;

    protected $table = 'prestation_pti_conteneur';
    protected $primaryKey = 'id_prestation_pti';
    public $incrementing = true;
    public $timestamps = true;
    protected $connection = 'eolis';
    
    
    protected $fillable = ['no_tc','username','observation','date_pti','sitestok','app','created_at','updated_at'];

    public function tcs_base()
    {
        return $this->hasOne('App\Models\Old\Eolis\TcsBase', 'no_tc', 'no_tc'/*'codeport'*/);
    }

    public function engin()
    {
        return $this->hasOne('App\Models\Old\Parc\Engin', 'idengin', 'idengin'/*'codeport'*/);
    }
}