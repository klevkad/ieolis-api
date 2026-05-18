<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTcFinal extends Model
{
    use HasFactory;

    protected $table = 'booking_final_tc';
    protected $primaryKey = 'idbooking_final_tc';
    public $incrementing = true;
    //public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'iddemande_booking',
        'no_declaration',
        'poids_brut',
        'volume',
        'nobookingfin',
        'plomb1',
        'plomb2',
        'plein_vide'
    ];

    public function bookingtc()
    {
        return $this->belongsTo('App\Models\Export\BookingTc','iddemande_booking','iddemande_booking');
    }

    public function demandebooking()
    {
        return $this->belongsTo('App\Models\Export\DemandeBooking','iddemande_booking','iddemande_booking');
    }
}
