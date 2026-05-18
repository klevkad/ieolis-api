<?php

namespace App\Observers\Export;

use App\Models\Export\AttributionCliponVerif;
use App\Traits\HasUserstamps;

class AttributionCliponVerifObserver
{
    use HasUserstamps;
    
    /**
     * Handle the attribution clipon verif "created" event.
     *
     * @param  \App\Models\Export\AttributionCliponVerif  $attributionCliponVerif
     * @return void
     */
    public function created(AttributionCliponVerif $attributionCliponVerif)
    {
        //
    }

    /**
     * Handle the attribution clipon verif "updated" event.
     *
     * @param  \App\Models\Export\AttributionCliponVerif  $attributionCliponVerif
     * @return void
     */
    public function updated(AttributionCliponVerif $attributionCliponVerif)
    {
        //
    }

    /**
     * Handle the attribution clipon verif "deleted" event.
     *
     * @param  \App\Models\Export\AttributionCliponVerif  $attributionCliponVerif
     * @return void
     */
    public function deleted(AttributionCliponVerif $attributionCliponVerif)
    {
        //
    }

    /**
     * Handle the attribution clipon verif "restored" event.
     *
     * @param  \App\Models\Export\AttributionCliponVerif  $attributionCliponVerif
     * @return void
     */
    public function restored(AttributionCliponVerif $attributionCliponVerif)
    {
        //
    }

    /**
     * Handle the attribution clipon verif "force deleted" event.
     *
     * @param  \App\Models\Export\AttributionCliponVerif  $attributionCliponVerif
     * @return void
     */
    public function forceDeleted(AttributionCliponVerif $attributionCliponVerif)
    {
        //
    }
}
