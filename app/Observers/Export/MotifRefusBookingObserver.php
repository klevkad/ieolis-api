<?php

namespace App\Observers\Export;

use App\Models\Export\MotifRefusBooking;
use App\Traits\HasUserstamps;

class MotifRefusBookingObserver
{
    use HasUserstamps;
    
    /**
     * Handle the motif refus booking "created" event.
     *
     * @param  \App\Models\Export\MotifRefusBooking  $motifRefusBooking
     * @return void
     */
    public function created(MotifRefusBooking $motifRefusBooking)
    {
        //
    }

    /**
     * Handle the motif refus booking "updated" event.
     *
     * @param  \App\Models\Export\MotifRefusBooking  $motifRefusBooking
     * @return void
     */
    public function updated(MotifRefusBooking $motifRefusBooking)
    {
        //
    }

    /**
     * Handle the motif refus booking "deleted" event.
     *
     * @param  \App\Models\Export\MotifRefusBooking  $motifRefusBooking
     * @return void
     */
    public function deleted(MotifRefusBooking $motifRefusBooking)
    {
        //
    }

    /**
     * Handle the motif refus booking "restored" event.
     *
     * @param  \App\Models\Export\MotifRefusBooking  $motifRefusBooking
     * @return void
     */
    public function restored(MotifRefusBooking $motifRefusBooking)
    {
        //
    }

    /**
     * Handle the motif refus booking "force deleted" event.
     *
     * @param  \App\Models\Export\MotifRefusBooking  $motifRefusBooking
     * @return void
     */
    public function forceDeleted(MotifRefusBooking $motifRefusBooking)
    {
        //
    }
}
