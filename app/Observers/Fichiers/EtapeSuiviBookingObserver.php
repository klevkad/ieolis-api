<?php

namespace App\Observers\Fichiers;

use App\Models\Fichiers\EtapeSuiviBooking;
use App\Traits\HasUserstamps;

class EtapeSuiviBookingObserver
{
    use HasUserstamps;
    
    /**
     * Handle the etape suivi booking "created" event.
     *
     * @param  \App\Models\Fichiers\EtapeSuiviBooking  $etapeSuiviBooking
     * @return void
     */
    public function created(EtapeSuiviBooking $etapeSuiviBooking)
    {
        //
    }

    /**
     * Handle the etape suivi booking "updated" event.
     *
     * @param  \App\Models\Fichiers\EtapeSuiviBooking  $etapeSuiviBooking
     * @return void
     */
    public function updated(EtapeSuiviBooking $etapeSuiviBooking)
    {
        //
    }

    /**
     * Handle the etape suivi booking "deleted" event.
     *
     * @param  \App\Models\Fichiers\EtapeSuiviBooking  $etapeSuiviBooking
     * @return void
     */
    public function deleted(EtapeSuiviBooking $etapeSuiviBooking)
    {
        //
    }

    /**
     * Handle the etape suivi booking "restored" event.
     *
     * @param  \App\Models\Fichiers\EtapeSuiviBooking  $etapeSuiviBooking
     * @return void
     */
    public function restored(EtapeSuiviBooking $etapeSuiviBooking)
    {
        //
    }

    /**
     * Handle the etape suivi booking "force deleted" event.
     *
     * @param  \App\Models\Fichiers\EtapeSuiviBooking  $etapeSuiviBooking
     * @return void
     */
    public function forceDeleted(EtapeSuiviBooking $etapeSuiviBooking)
    {
        //
    }
}
