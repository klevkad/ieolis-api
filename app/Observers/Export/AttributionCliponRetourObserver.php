<?php

namespace App\Observers\Export;

use App\Models\Export\AttributionCliponRetour;
use App\Traits\HasUserstamps;

class AttributionCliponRetourObserver
{
    use HasUserstamps;
    
    /**
     * Handle the attribution clipon retour "created" event.
     *
     * @param  \App\Models\Export\AttributionCliponRetour  $attributionCliponRetour
     * @return void
     */
    public function created(AttributionCliponRetour $attributionCliponRetour)
    {
        //
    }

    /**
     * Handle the attribution clipon retour "updated" event.
     *
     * @param  \App\Models\Export\AttributionCliponRetour  $attributionCliponRetour
     * @return void
     */
    public function updated(AttributionCliponRetour $attributionCliponRetour)
    {
        //
    }

    /**
     * Handle the attribution clipon retour "deleted" event.
     *
     * @param  \App\Models\Export\AttributionCliponRetour  $attributionCliponRetour
     * @return void
     */
    public function deleted(AttributionCliponRetour $attributionCliponRetour)
    {
        //
    }

    /**
     * Handle the attribution clipon retour "restored" event.
     *
     * @param  \App\Models\Export\AttributionCliponRetour  $attributionCliponRetour
     * @return void
     */
    public function restored(AttributionCliponRetour $attributionCliponRetour)
    {
        //
    }

    /**
     * Handle the attribution clipon retour "force deleted" event.
     *
     * @param  \App\Models\Export\AttributionCliponRetour  $attributionCliponRetour
     * @return void
     */
    public function forceDeleted(AttributionCliponRetour $attributionCliponRetour)
    {
        //
    }
}
