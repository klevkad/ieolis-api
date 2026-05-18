<?php

namespace App\Observers\Fichiers;

use App\Models\Fichiers\Panne;
use App\Traits\HasUserstamps;

class PanneObserver
{
    use HasUserstamps;
    
    /**
     * Handle the Panne "created" event.
     *
     * @param  \App\Models\Fichiers\Panne  $panne
     * @return void
     */
    public function created(Panne $panne)
    {
        //
    }

    /**
     * Handle the Panne "updated" event.
     *
     * @param  \App\Models\Fichiers\Panne  $panne
     * @return void
     */
    public function updated(Panne $panne)
    {
        //
    }

    /**
     * Handle the Panne "deleted" event.
     *
     * @param  \App\Models\Fichiers\Panne  $panne
     * @return void
     */
    public function deleted(Panne $panne)
    {
        //
    }

    /**
     * Handle the Panne "restored" event.
     *
     * @param  \App\Models\Fichiers\Panne  $panne
     * @return void
     */
    public function restored(Panne $panne)
    {
        //
    }

    /**
     * Handle the Panne "force deleted" event.
     *
     * @param  \App\Models\Fichiers\Panne  $panne
     * @return void
     */
    public function forceDeleted(Panne $panne)
    {
        //
    }
}
