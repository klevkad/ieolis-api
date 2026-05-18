<?php

namespace App\Observers\Export;

use App\Models\Export\FinPositTc;
use App\Traits\HasUserstamps;

class FinPositTcObserver
{
    use HasUserstamps;
    
    /**
     * Handle the fin posit tc "created" event.
     *
     * @param  \App\Models\Export\FinPositTc  $finPositTc
     * @return void
     */
    public function created(FinPositTc $finPositTc)
    {
        //
    }

    /**
     * Handle the fin posit tc "updated" event.
     *
     * @param  \App\Models\Export\FinPositTc  $finPositTc
     * @return void
     */
    public function updated(FinPositTc $finPositTc)
    {
        //
    }

    /**
     * Handle the fin posit tc "deleted" event.
     *
     * @param  \App\Models\Export\FinPositTc  $finPositTc
     * @return void
     */
    public function deleted(FinPositTc $finPositTc)
    {
        //
    }

    /**
     * Handle the fin posit tc "restored" event.
     *
     * @param  \App\Models\Export\FinPositTc  $finPositTc
     * @return void
     */
    public function restored(FinPositTc $finPositTc)
    {
        //
    }

    /**
     * Handle the fin posit tc "force deleted" event.
     *
     * @param  \App\Models\Export\FinPositTc  $finPositTc
     * @return void
     */
    public function forceDeleted(FinPositTc $finPositTc)
    {
        //
    }
}
