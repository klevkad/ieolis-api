<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetourTcMain extends Model
{
    use HasFactory;

    protected $table = 'retour_tc_main';
    protected $primaryKey = 'idretour_tc';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = ['model_type'];


    public function retourtc()
    {
        return $this->hasOne('App\Models\Export\RetourTc','idretour_conteneur','idretour_tc');
    }

    public function retourtcpropremoyen()
    {
        return $this->hasOne('App\Models\Export\RetourTcPropreMoyen','idretour_tc','idretour_tc');
    }
}
