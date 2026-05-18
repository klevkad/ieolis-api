<?php

namespace App\Observers\Export;

use App\Models\Export\FinRetourTc;
use App\Traits\HasUserstamps;

class FinRetourTcObserver
{
    use HasUserstamps;
    
    /**
     * Handle the fin retour tc "created" event.
     *
     * @param  \App\Models\Export\FinRetourTc  $finRetourTc
     * @return void
     */
    public function created(FinRetourTc $finRetourTc)
    {
        //
    }

    /**
     * Handle the fin retour tc "updated" event.
     *
     * @param  \App\Models\Export\FinRetourTc  $finRetourTc
     * @return void
     */
    public function updated(FinRetourTc $finRetourTc)
    {
        //
    }

    /**
     * Handle the fin retour tc "deleted" event.
     *
     * @param  \App\Models\Export\FinRetourTc  $finRetourTc
     * @return void
     */
    public function deleted(FinRetourTc $finRetourTc)
    {
        //
    }

    /**
     * Handle the fin retour tc "restored" event.
     *
     * @param  \App\Models\Export\FinRetourTc  $finRetourTc
     * @return void
     */
    public function restored(FinRetourTc $finRetourTc)
    {
        //
    }

    /**
     * Handle the fin retour tc "force deleted" event.
     *
     * @param  \App\Models\Export\FinRetourTc  $finRetourTc
     * @return void
     */
    public function forceDeleted(FinRetourTc $finRetourTc)
    {
        //
    }
}
