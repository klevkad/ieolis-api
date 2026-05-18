<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prevision_Debarq extends Model
{
    use HasFactory;

    protected $table = 'prevision_debarq';
    protected $primaryKey = 'idprev_debarq';
//    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'eolis';
    
    protected $fillable = [];

    public function escale()
    {
        return $this->hasOne(Escale::class,'noescale','noescale');
    }

    public function operateu()
    {
        return $this->hasOne(Operateu::class,'codeoper','codeoper');
    }

    public function prevdebarqtcmanif()
    {
        return $this->hasOne(Prevs_Debarq_Tcmanif::class,'idprev_debarq','idprev_debarq');
    }

    public function prevdebarqtcnmanif()
    {
        return $this->hasOne(Prevs_Debarq_Tcnmanif::class,'idprev_debarq','idprev_debarq');
    }

    public function prevdebarqvrac()
    {
        return $this->hasOne(Prevs_Debarq_Vrac::class,'idprev_debarq','idprev_debarq');
    }

}
