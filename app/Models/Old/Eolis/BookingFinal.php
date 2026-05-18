<?php

namespace App\Models\Old\Eolis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingFinal extends Model
{
    use HasFactory;

    protected $table = 'bookingfinal';
    protected $primaryKey = 'idbookingfinal';
    public $incrementing = true;
    public $timestamps = false;
    protected $connection = 'eolis';

    protected $fillable = [
        'idbookingfinal',
        'etat_emb',
        'embarque'
    ];

//     public function bookingtc()
//     {
//         return $this->belongsTo('App\Models\Export\BookingTc','iddemande_booking','iddemande_booking');
//     }

//     public function demandebooking()
//     {
//         return $this->belongsTo('App\Models\Export\DemandeBooking','iddemande_booking','iddemande_booking');
//     }
 }
