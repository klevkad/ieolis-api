<?php

namespace App\Observers\Old\Parc;

use App\Models\Old\Parc\Chargeur;
use App\Traits\HasUserstamps;

class ChargeurObserver
{
    use HasUserstamps;

    /**
     * Handle the Chargeur "created" event.
     *
     * @param  \App\Models\Old\Parc\Chargeur  $chargeur
     * @return void
     */
    public function created(Chargeur $chargeur)
    {
        //
    }

    /**
     * Handle the Chargeur "updated" event.
     *
     * @param  \App\Models\Old\Parc\Chargeur  $chargeur
     * @return void
     */
    public function updated(Chargeur $chargeur)
    {
        //
    }

    /**
     * Handle the Chargeur "deleted" event.
     *
     * @param  \App\Models\Old\Parc\Chargeur  $chargeur
     * @return void
     */
    public function deleted(Chargeur $chargeur)
    {
        //
    }

    /**
     * Handle the Chargeur "restored" event.
     *
     * @param  \App\Models\Old\Parc\Chargeur  $chargeur
     * @return void
     */
    public function restored(Chargeur $chargeur)
    {
        //
    }

    /**
     * Handle the Chargeur "force deleted" event.
     *
     * @param  \App\Models\Old\Parc\Chargeur  $chargeur
     * @return void
     */
    public function forceDeleted(Chargeur $chargeur)
    {
        //
    }
}
