<?php

namespace App\Observers\Fichiers;

use App\Models\Fichiers\LieuAppro;
use App\Traits\HasUserstamps;

class LieuApproObserver
{
    use HasUserstamps;
    
    /**
     * Handle the lieu appro "created" event.
     *
     * @param  \App\Models\Fichiers\LieuAppro  $lieuAppro
     * @return void
     */
    public function created(LieuAppro $lieuAppro)
    {
        //
    }

    /**
     * Handle the lieu appro "updated" event.
     *
     * @param  \App\Models\Fichiers\LieuAppro  $lieuAppro
     * @return void
     */
    public function updated(LieuAppro $lieuAppro)
    {
        //
    }

    /**
     * Handle the lieu appro "deleted" event.
     *
     * @param  \App\Models\Fichiers\LieuAppro  $lieuAppro
     * @return void
     */
    public function deleted(LieuAppro $lieuAppro)
    {
        //
    }

    /**
     * Handle the lieu appro "restored" event.
     *
     * @param  \App\Models\Fichiers\LieuAppro  $lieuAppro
     * @return void
     */
    public function restored(LieuAppro $lieuAppro)
    {
        //
    }

    /**
     * Handle the lieu appro "force deleted" event.
     *
     * @param  \App\Models\Fichiers\LieuAppro  $lieuAppro
     * @return void
     */
    public function forceDeleted(LieuAppro $lieuAppro)
    {
        //
    }
}
