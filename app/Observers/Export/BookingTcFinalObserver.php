<?php

namespace App\Observers\Export;

use App\Models\Export\BookingTcFinal;
use App\Traits\HasUserstamps;

class BookingTcFinalObserver
{
    use HasUserstamps;
    
    /**
     * Handle the booking tc final "created" event.
     *
     * @param  \App\Models\Export\BookingTcFinal  $bookingTcFinal
     * @return void
     */
    public function created(BookingTcFinal $bookingTcFinal)
    {
        //
    }

    /**
     * Handle the booking tc final "updated" event.
     *
     * @param  \App\Models\Export\BookingTcFinal  $bookingTcFinal
     * @return void
     */
    public function updated(BookingTcFinal $bookingTcFinal)
    {
        //
    }

    /**
     * Handle the booking tc final "deleted" event.
     *
     * @param  \App\Models\Export\BookingTcFinal  $bookingTcFinal
     * @return void
     */
    public function deleted(BookingTcFinal $bookingTcFinal)
    {
        //
    }

    /**
     * Handle the booking tc final "restored" event.
     *
     * @param  \App\Models\Export\BookingTcFinal  $bookingTcFinal
     * @return void
     */
    public function restored(BookingTcFinal $bookingTcFinal)
    {
        //
    }

    /**
     * Handle the booking tc final "force deleted" event.
     *
     * @param  \App\Models\Export\BookingTcFinal  $bookingTcFinal
     * @return void
     */
    public function forceDeleted(BookingTcFinal $bookingTcFinal)
    {
        //
    }
}
