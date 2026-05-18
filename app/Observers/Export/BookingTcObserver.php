<?php

namespace App\Observers\Export;

use App\Models\Export\BookingTc;
use App\Traits\HasUserstamps;

class BookingTcObserver
{
    use HasUserstamps;
    
    /**
     * Handle the booking tc "created" event.
     *
     * @param  \App\Models\Export\BookingTc  $bookingTc
     * @return void
     */
    public function created(BookingTc $bookingTc)
    {
        //
    }

    /**
     * Handle the booking tc "updated" event.
     *
     * @param  \App\Models\Export\BookingTc  $bookingTc
     * @return void
     */
    public function updated(BookingTc $bookingTc)
    {
        //
    }

    /**
     * Handle the booking tc "deleted" event.
     *
     * @param  \App\Models\Export\BookingTc  $bookingTc
     * @return void
     */
    public function deleted(BookingTc $bookingTc)
    {
        //
    }

    /**
     * Handle the booking tc "restored" event.
     *
     * @param  \App\Models\Export\BookingTc  $bookingTc
     * @return void
     */
    public function restored(BookingTc $bookingTc)
    {
        //
    }

    /**
     * Handle the booking tc "force deleted" event.
     *
     * @param  \App\Models\Export\BookingTc  $bookingTc
     * @return void
     */
    public function forceDeleted(BookingTc $bookingTc)
    {
        //
    }
}
