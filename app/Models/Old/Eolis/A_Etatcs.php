<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class A_Etatcs extends Model
{
    use HasFactory;

    protected $table = 'a_etatcs';
    protected $primaryKey = 'id_auto';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'eolis';
    

    protected $fillable = ['id_auto','noescale', 'no_tc', 'code_mvt', 'date_mvt', 'top_transbordement','last_mvt','codeuser'];

    public function situation_mvt()
    {
        return $this->hasOne('App\Models\Old\Eolis\Situation_Tc', 'code_mvt', 'code_mvt'/*'codeport'*/);
    }
}
