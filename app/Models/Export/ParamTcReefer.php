<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParamTcReefer extends Model
{
    use HasFactory;

    protected $table = 'param_tc_reefer';
    protected $primaryKey = 'idparam_tc_reefer';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'idbooking_conteneur',
        'setpoint',
        'volet'
    ];

    public function bookingtc()
    {
        return $this->belongsTo('App\Models\Export\BookingTC','idbooking_conteneur','idbooking_conteneur');
    }
}
