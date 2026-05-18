<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class A_Tcsemb extends Model
{
    use HasFactory;

    protected $table = 'a_tcsemb';
    protected $primaryKey = 'idtcsemb';
    public $incrementing = false; 
    public $timestamps = false;
    protected $connection = 'eolis';

    protected $fillable = ['idtcsemb','noescale', 'no_tc','plomb2','idbookingfinal', 'date_mvt', 'datesaisie', 'port_emb', 'plomb1','p1','p2', 'top_tbdt', 'codeuser','tare_tc','app'];

    public function escale()
    {
        return $this->hasOne('App\Models\Old\Eolis\Escale', 'noescale', 'noescale');
    }

    public function port_orig()
    {
        return $this->hasOne('App\Models\Old\Eolis\Port', 'codeport', 'port_emb');
    }

    public function port_dest()
    {
        return $this->hasOne('App\Models\Old\Eolis\Port', 'codeport', 'port_deb');
    }

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('noescale', '=', $this->getAttribute('noescale'))
            ->where('no_tc', '=', $this->getAttribute('no_tc'));
        return $query;
    }
}
