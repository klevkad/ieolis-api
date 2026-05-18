<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prevs_Debarq_Tcmanif extends Model
{
    use HasFactory;

    protected $table = 'prevs_debarq_tcmanif';
    protected $primaryKey = 'idprev_debarq_tcmanif';
//    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'eolis';
    
    protected $fillable = [];
    protected $with = ['conteneu'];

    public function conteneu()
    {
        return $this->hasOne(Conteneu::class,'idconteneu','idconteneu');
    }

    public function prevdebarq()
    {
        return $this->hasOne(Prevision_Debarq::class,'idprev_debarq','idprev_debarq');
    }

}
