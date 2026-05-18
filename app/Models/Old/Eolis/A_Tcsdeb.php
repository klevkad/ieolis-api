<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class A_Tcsdeb extends Model
{
    use HasFactory;

    protected $table = 'a_tcsdeb';
    protected $primaryKey = 'idtcsdeb';
    public $incrementing = true;
    public $timestamps = false; 
    protected $connection = 'eolis';
    
    protected $fillable = ['idtcsdeb','idprev_debarq', 'no_tc', 'noescale', 'date_deb', 'plein_vide', 'id_etat','plomb1','plomb2','app','p1','p2', 'codeuser','top_tbdt'];

    public function bl()
    {
        return $this->hasOne('App\Models\Old\Eolis\Bls', 'idbl', 'idbl'/*'codeport'*/);
    }

    public function port_orig()
    {
        return $this->hasOne('App\Models\Old\Eolis\Port', 'codeport', 'port_emb'/*'codeport'*/);
    }

    public function port_dest()
    {
        return $this->hasOne('App\Models\Old\Eolis\Port', 'codeport', 'port_deb'/*'codeport_deb'*/);
    }
}
