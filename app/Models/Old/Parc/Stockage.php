<?php

namespace App\Models\Old\Parc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stockage extends Model
{
    use HasFactory;
    
    protected $table = 'stockage';
    // protected $primaryKey = 'idbon';
    // public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'parc';
    protected $keyType = 'string';

    protected $fillable = ['idpiece','qte_tps_reel',"qte_sortie"];

}
