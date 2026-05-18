<?php

namespace App\Observers\Export;

use App\Models\Export\FinRetourCliponVerif;
use App\Traits\HasUserstamps;

class FinRetourCliponVerifObserver
{
    use HasUserstamps;
    
    /**
     * Handle the fin retour clipon verif "created" event.
     *
     * @param  \App\Models\Export\FinRetourCliponVerif  $finRetourCliponVerif
     * @return void
     */
    public function created(FinRetourCliponVerif $finRetourCliponVerif)
    {
        //
    }

    /**
     * Handle the fin retour clipon verif "updated" event.
     *
     * @param  \App\Models\Export\FinRetourCliponVerif  $finRetourCliponVerif
     * @return void
     */
    public function updated(FinRetourCliponVerif $finRetourCliponVerif)
    {
        //
    }

    /**
     * Handle the fin retour clipon verif "deleted" event.
     *
     * @param  \App\Models\Export\FinRetourCliponVerif  $finRetourCliponVerif
     * @return void
     */
    public function deleted(FinRetourCliponVerif $finRetourCliponVerif)
    {
        //
    }

    /**
     * Handle the fin retour clipon verif "restored" event.
     *
     * @param  \App\Models\Export\FinRetourCliponVerif  $finRetourCliponVerif
     * @return void
     */
    public function restored(FinRetourCliponVerif $finRetourCliponVerif)
    {
        //
    }

    /**
     * Handle the fin retour clipon verif "force deleted" event.
     *
     * @param  \App\Models\Export\FinRetourCliponVerif  $finRetourCliponVerif
     * @return void
     */
    public function forceDeleted(FinRetourCliponVerif $finRetourCliponVerif)
    {
        //
    }
}
