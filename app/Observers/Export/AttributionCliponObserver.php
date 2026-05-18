<?php

namespace App\Observers\Export;

use App\Models\Export\AttributionClipon;
use App\Traits\HasUserstamps;

class AttributionCliponObserver
{
    use HasUserstamps;
    
    /**
     * Handle the attribution clipon "created" event.
     *
     * @param  \App\Models\Export\AttributionClipon  $attributionClipon
     * @return void
     */
    public function created(AttributionClipon $attributionClipon)
    {
        //
    }

    /**
     * Handle the attribution clipon "updated" event.
     *
     * @param  \App\Models\Export\AttributionClipon  $attributionClipon
     * @return void
     */
    public function updated(AttributionClipon $attributionClipon)
    {
        //
    }

    /**
     * Handle the attribution clipon "deleted" event.
     *
     * @param  \App\Models\Export\AttributionClipon  $attributionClipon
     * @return void
     */
    public function deleted(AttributionClipon $attributionClipon)
    {
        //
    }

    /**
     * Handle the attribution clipon "restored" event.
     *
     * @param  \App\Models\Export\AttributionClipon  $attributionClipon
     * @return void
     */
    public function restored(AttributionClipon $attributionClipon)
    {
        //
    }

    /**
     * Handle the attribution clipon "force deleted" event.
     *
     * @param  \App\Models\Export\AttributionClipon  $attributionClipon
     * @return void
     */
    public function forceDeleted(AttributionClipon $attributionClipon)
    {
        //
    }
}
