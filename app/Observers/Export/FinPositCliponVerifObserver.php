<?php

namespace App\Observers\Export;

use App\Models\Export\FinPositCliponVerif;
use App\Traits\HasUserstamps;

class FinPositCliponVerifObserver
{
    use HasUserstamps;
    
    /**
     * Handle the fin posit clipon verif "created" event.
     *
     * @param  \App\Models\Export\FinPositCliponVerif  $finPositCliponVerif
     * @return void
     */
    public function created(FinPositCliponVerif $finPositCliponVerif)
    {
        //
    }

    /**
     * Handle the fin posit clipon verif "updated" event.
     *
     * @param  \App\Models\Export\FinPositCliponVerif  $finPositCliponVerif
     * @return void
     */
    public function updated(FinPositCliponVerif $finPositCliponVerif)
    {
        //
    }

    /**
     * Handle the fin posit clipon verif "deleted" event.
     *
     * @param  \App\Models\Export\FinPositCliponVerif  $finPositCliponVerif
     * @return void
     */
    public function deleted(FinPositCliponVerif $finPositCliponVerif)
    {
        //
    }

    /**
     * Handle the fin posit clipon verif "restored" event.
     *
     * @param  \App\Models\Export\FinPositCliponVerif  $finPositCliponVerif
     * @return void
     */
    public function restored(FinPositCliponVerif $finPositCliponVerif)
    {
        //
    }

    /**
     * Handle the fin posit clipon verif "force deleted" event.
     *
     * @param  \App\Models\Export\FinPositCliponVerif  $finPositCliponVerif
     * @return void
     */
    public function forceDeleted(FinPositCliponVerif $finPositCliponVerif)
    {
        //
    }
}
