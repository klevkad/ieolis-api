<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prevs_Debarq_Vrac extends Model
{
    use HasFactory;

    protected $table = 'prevs_debarq_vrac';
    protected $primaryKey = 'idprev_debarq_vrac';
//    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'eolis';
    
    protected $fillable = [];
    protected $with = ['convcont'];

    public function convcont()
    {
        return $this->hasOne(Convcont::class,'idconvcont','idconvcont');
    }

    public function prevdebarq()
    {
        return $this->hasOne(Prevision_Debarq::class,'idprev_debarq','idprev_debarq');
    }

}
