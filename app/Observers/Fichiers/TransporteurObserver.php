<?php

namespace App\Observers\Fichiers;

use App\Models\Fichiers\Transporteur;
use App\Traits\HasUserstamps;

class TransporteurObserver
{
    use HasUserstamps;
    
    /**
     * Handle the transporteur "created" event.
     *
     * @param  \App\Models\Fichiers\Transporteur  $transporteur
     * @return void
     */
    public function created(Transporteur $transporteur)
    {
        //
    }

    /**
     * Handle the transporteur "updated" event.
     *
     * @param  \App\Models\Fichiers\Transporteur  $transporteur
     * @return void
     */
    public function updated(Transporteur $transporteur)
    {
        //
    }

    /**
     * Handle the transporteur "deleted" event.
     *
     * @param  \App\Models\Fichiers\Transporteur  $transporteur
     * @return void
     */
    public function deleted(Transporteur $transporteur)
    {
        //
    }

    /**
     * Handle the transporteur "restored" event.
     *
     * @param  \App\Models\Fichiers\Transporteur  $transporteur
     * @return void
     */
    public function restored(Transporteur $transporteur)
    {
        //
    }

    /**
     * Handle the transporteur "force deleted" event.
     *
     * @param  \App\Models\Fichiers\Transporteur  $transporteur
     * @return void
     */
    public function forceDeleted(Transporteur $transporteur)
    {
        //
    }
}
