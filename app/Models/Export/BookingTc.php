<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTc extends Model
{
    use HasFactory;

    protected $table = 'booking_conteneur';
    protected $primaryKey = 'idbooking_conteneur';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'iddemande_booking',
        'codetype_tc',
        'nb_tcs',
        'nb_tcs_def',
        'date_posit_souhait'
    ];

    public function demandebooking()
    {
        return $this->belongsTo('App\Models\Export\DemandeBooking','iddemande_booking','iddemande_booking');
    }

    public function bookingtcfinal()
    {
        return $this->hasOne('App\Models\Export\BookingTCFinal', 'iddemande_booking', 'iddemande_booking');
    }

    public function paramtcreefer()
    {
        return $this->hasOne('App\Models\Export\ParamTCReefer', 'idbooking_conteneur', 'idbooking_conteneur');
    }

    public function attributiontcs()
    {
        return $this->hasMany('App\Models\Export\AttributionTC', 'idbooking_conteneur', 'idbooking_conteneur');
    }
}
