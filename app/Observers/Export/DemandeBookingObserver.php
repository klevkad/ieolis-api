<?php

namespace App\Observers\Export;

use App\Models\Export\DemandeBooking;
use App\Traits\HasUserstamps;

class DemandeBookingObserver
{
    use HasUserstamps;
    
    /**
     * Handle the demande booking "created" event.
     *
     * @param  \App\Models\Export\DemandeBooking  $demandeBooking
     * @return void
     */
    public function created(DemandeBooking $demandeBooking)
    {
        //
    }

    /**
     * Handle the demande booking "updated" event.
     *
     * @param  \App\Models\Export\DemandeBooking  $demandeBooking
     * @return void
     */
    public function updated(DemandeBooking $demandeBooking)
    {
        //
    }

    /**
     * Handle the demande booking "deleted" event.
     *
     * @param  \App\Models\Export\DemandeBooking  $demandeBooking
     * @return void
     */
    public function deleted(DemandeBooking $demandeBooking)
    {
        //
    }

    /**
     * Handle the demande booking "restored" event.
     *
     * @param  \App\Models\Export\DemandeBooking  $demandeBooking
     * @return void
     */
    public function restored(DemandeBooking $demandeBooking)
    {
        //
    }

    /**
     * Handle the demande booking "force deleted" event.
     *
     * @param  \App\Models\Export\DemandeBooking  $demandeBooking
     * @return void
     */
    public function forceDeleted(DemandeBooking $demandeBooking)
    {
        //
    }
}
