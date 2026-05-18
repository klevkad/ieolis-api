<?php

namespace App\Observers\Fichiers;

use App\Models\Fichiers\RLieu;

class RLieuObserver
{
    /**
     * Handle the RLieu "created" event.
     *
     * @param  \App\Models\Fichiers\RLieu  $rLieu
     * @return void
     */
    public function created(RLieu $rLieu)
    {
        //
    }

    /**
     * Handle the RLieu "updated" event.
     *
     * @param  \App\Models\Fichiers\RLieu  $rLieu
     * @return void
     */
    public function updated(RLieu $rLieu)
    {
        //
    }

    /**
     * Handle the RLieu "deleted" event.
     *
     * @param  \App\Models\Fichiers\RLieu  $rLieu
     * @return void
     */
    public function deleted(RLieu $rLieu)
    {
        //
    }

    /**
     * Handle the RLieu "restored" event.
     *
     * @param  \App\Models\Fichiers\RLieu  $rLieu
     * @return void
     */
    public function restored(RLieu $rLieu)
    {
        //
    }

    /**
     * Handle the RLieu "force deleted" event.
     *
     * @param  \App\Models\Fichiers\RLieu  $rLieu
     * @return void
     */
    public function forceDeleted(RLieu $rLieu)
    {
        //
    }
}
