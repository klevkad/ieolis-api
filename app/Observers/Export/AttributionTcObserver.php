<?php

namespace App\Observers\Export;

use App\Models\Export\AttributionTc;
use App\Traits\HasUserstamps;

class AttributionTcObserver
{
    use HasUserstamps;
    
    /**
     * Handle the attribution tc "created" event.
     *
     * @param  \App\Models\Export\AttributionTc  $attributionTc
     * @return void
     */
    public function created(AttributionTc $attributionTc)
    {
        //
    }

    /**
     * Handle the attribution tc "updated" event.
     *
     * @param  \App\Models\Export\AttributionTc  $attributionTc
     * @return void
     */
    public function updated(AttributionTc $attributionTc)
    {
        //
    }

    /**
     * Handle the attribution tc "deleted" event.
     *
     * @param  \App\Models\Export\AttributionTc  $attributionTc
     * @return void
     */
    public function deleted(AttributionTc $attributionTc)
    {
        //
    }

    /**
     * Handle the attribution tc "restored" event.
     *
     * @param  \App\Models\Export\AttributionTc  $attributionTc
     * @return void
     */
    public function restored(AttributionTc $attributionTc)
    {
        //
    }

    /**
     * Handle the attribution tc "force deleted" event.
     *
     * @param  \App\Models\Export\AttributionTc  $attributionTc
     * @return void
     */
    public function forceDeleted(AttributionTc $attributionTc)
    {
        //
    }
}
