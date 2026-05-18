<?php

namespace App\Models\Fichiers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtapeSuiviBooking extends Model
{
    use HasFactory;

    protected $table = 'etape_suivi_booking';
    protected $primaryKey = 'codeetape_suivi_booking';
    public $timestamps = false;
    protected $connection = 'booking';

    protected $fillable = [
        'libelle_etape',
        'ordre_etape'
    ];

    public function demandebookings()
    {
        return $this->belongsToMany('App\Models\Export\DemandeBooking', 'a_etape_booking', 'codeetape_suivi_booking', 'iddemande_booking')->withPivot('dateetape','id_agent');
    }
}
