<?php

namespace App\Observers\Old\Parc;

use App\Models\Old\Parc\OI;

class OIObserver
{
    /**
     * Handle the OI "created" event.
     *
     * @param  \App\Models\Old\Parc\OI  $oI
     * @return void
     */
    public function created(OI $oI)
    {
        //
    }

    /**
     * Handle the OI "updated" event.
     *
     * @param  \App\Models\Old\Parc\OI  $oI
     * @return void
     */
    public function updated(OI $oI)
    {
        //
    }

    /**
     * Handle the OI "deleted" event.
     *
     * @param  \App\Models\Old\Parc\OI  $oI
     * @return void
     */
    public function deleted(OI $oI)
    {
        //
    }

    /**
     * Handle the OI "restored" event.
     *
     * @param  \App\Models\Old\Parc\OI  $oI
     * @return void
     */
    public function restored(OI $oI)
    {
        //
    }

    /**
     * Handle the OI "force deleted" event.
     *
     * @param  \App\Models\Old\Parc\OI  $oI
     * @return void
     */
    public function forceDeleted(OI $oI)
    {
        //
    }
}
