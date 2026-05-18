<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conteneu extends Model
{
    use HasFactory;

    protected $table = 'conteneu';
    protected $primaryKey = 'idconteneu';
//    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'eolis';
    
    protected $fillable = [];

    public function prevdebarqtcmanif()
    {
        return $this->hasOne(Prevs_Debarq_Tcmanif::class,'idconteneu','idconteneu');
    }

    public function bl()
    {
        return $this->hasOne(Bls::class,'idbl','idbl');
    }

    public function tcsbase()
    {
        return $this->hasOne(TcsBase::class,'no_tc','no_tc');
    }
}
