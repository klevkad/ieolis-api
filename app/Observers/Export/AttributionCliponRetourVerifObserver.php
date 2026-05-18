<?php

namespace App\Observers\Export;

use App\Models\Export\AttributionCliponRetourVerif;
use App\Traits\HasUserstamps;

class AttributionCliponRetourVerifObserver
{
    use HasUserstamps;
    
    /**
     * Handle the attribution clipon retour verif "created" event.
     *
     * @param  \App\Models\Export\AttributionCliponRetourVerif  $attributionCliponRetourVerif
     * @return void
     */
    public function created(AttributionCliponRetourVerif $attributionCliponRetourVerif)
    {
        //
    }

    /**
     * Handle the attribution clipon retour verif "updated" event.
     *
     * @param  \App\Models\Export\AttributionCliponRetourVerif  $attributionCliponRetourVerif
     * @return void
     */
    public function updated(AttributionCliponRetourVerif $attributionCliponRetourVerif)
    {
        //
    }

    /**
     * Handle the attribution clipon retour verif "deleted" event.
     *
     * @param  \App\Models\Export\AttributionCliponRetourVerif  $attributionCliponRetourVerif
     * @return void
     */
    public function deleted(AttributionCliponRetourVerif $attributionCliponRetourVerif)
    {
        //
    }

    /**
     * Handle the attribution clipon retour verif "restored" event.
     *
     * @param  \App\Models\Export\AttributionCliponRetourVerif  $attributionCliponRetourVerif
     * @return void
     */
    public function restored(AttributionCliponRetourVerif $attributionCliponRetourVerif)
    {
        //
    }

    /**
     * Handle the attribution clipon retour verif "force deleted" event.
     *
     * @param  \App\Models\Export\AttributionCliponRetourVerif  $attributionCliponRetourVerif
     * @return void
     */
    public function forceDeleted(AttributionCliponRetourVerif $attributionCliponRetourVerif)
    {
        //
    }
}
