<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prevs_Debarq_Tcnmanif extends Model
{
    use HasFactory;

    protected $table = 'prevs_debarq_tcnmanif';
    protected $primaryKey = 'idprev_debarq_tcnmanif';
//    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'eolis';
    
    protected $fillable = [];
    protected $with = [];

    public function tcsbase()
    {
        return $this->hasOne(TcsBase::class,'no_tc','no_tc');
    }

    public function port()
    {
        return $this->hasOne(Port::class,'codeport','codeport');
    }

    public function prevdebarq()
    {
        return $this->hasOne(Prevision_Debarq::class,'idprev_debarq','idprev_debarq');
    }

}
