<?php

namespace App\Observers\Old\Etf;

use App\Models\Old\Etf\SuiviKm;
use App\Traits\HasUserstamps;

class SuiviKmObserver
{
    use HasUserstamps;

    /**
     * Handle the SuiviKm "created" event.
     *
     * @param  \App\Models\Old\Etf\SuiviKm  $suiviKm
     * @return void
     */
    public function created(SuiviKm $suiviKm)
    {
        //
    }

    /**
     * Handle the SuiviKm "updated" event.
     *
     * @param  \App\Models\Old\Etf\SuiviKm  $suiviKm
     * @return void
     */
    public function updated(SuiviKm $suiviKm)
    {
        //
    }

    /**
     * Handle the SuiviKm "deleted" event.
     *
     * @param  \App\Models\Old\Etf\SuiviKm  $suiviKm
     * @return void
     */
    public function deleted(SuiviKm $suiviKm)
    {
        //
    }

    /**
     * Handle the SuiviKm "restored" event.
     *
     * @param  \App\Models\Old\Etf\SuiviKm  $suiviKm
     * @return void
     */
    public function restored(SuiviKm $suiviKm)
    {
        //
    }

    /**
     * Handle the SuiviKm "force deleted" event.
     *
     * @param  \App\Models\Old\Etf\SuiviKm  $suiviKm
     * @return void
     */
    public function forceDeleted(SuiviKm $suiviKm)
    {
        //
    }
}
