<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convcont extends Model
{
    use HasFactory;

    protected $table = 'convcont';
    protected $primaryKey = 'idconvcont';
//    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'eolis';
    
    protected $fillable = [];

    public function prevdebarqvrac()
    {
        return $this->hasOne(Prevs_Debarq_Vrac::class,'idconvcont','idconvcont');
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
