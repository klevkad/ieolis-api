<?php

namespace App\Models\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotifRefusBooking extends Model
{
    use HasFactory;

    protected $table = 'motif_refus_booking';
    protected $primaryKey = 'idmotif_refus';
    public $incrementing = true;
    //public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'lib_motif',
        'iddemande_booking'
    ];

    public function demandebooking()
    {
        return $this->belongsTo('App\Models\Export\DemandeBooking','iddemande_booking','iddemande_booking');
    }
}
