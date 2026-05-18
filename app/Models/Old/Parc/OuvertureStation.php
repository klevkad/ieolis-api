<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OuvertureStation extends Model
{
    use HasFactory;
     
    protected $table = 'ouverture_stations';
    protected $primaryKey = 'ouverture_id';
    public $incrementing = false;
    public $timestamps = true;
    protected $connection = 'parc';
    protected $keyType = 'int';
    protected $fillable = ['ouverture_id','stationid','indexdebut','quantitedebut','indexfin','quantitefin','index_logique','dateouverture','datefermeture','created_by', 'updated_by'];
    protected $casts = [
        'dateouverture' => 'datetime', 
        'datefermeture' => 'datetime', 
    ];

    public function sorties()
    {
        return $this->hasMany('App\Models\Old\Parc\Sortie', 'id', 'ouverture_id');
    }
}
