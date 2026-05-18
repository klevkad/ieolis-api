<?php

namespace App\Observers\Fichiers;

use App\Models\Fichiers\Activites;
use App\Traits\HasUserstamps;

class ActivitesObserver
{
    use HasUserstamps;
    
    /**
     * Handle the activites "created" event.
     *
     * @param  \App\Models\Fichiers\Activites  $activite
     * @return void
     */
    public function created(Activites $activite)
    {
        //
    }

    /**
     * Handle the activites "updated" event.
     *
     * @param  \App\Models\Fichiers\Activites  $activite
     * @return void
     */
    public function updated(Activites $activite)
    {
        //
    }

    /**
     * Handle the activites "deleted" event.
     *
     * @param  \App\Models\Fichiers\Activites  $activite
     * @return void
     */
    public function deleted(Activites $activite)
    {
        //
    }

    /**
     * Handle the activites "restored" event.
     *
     * @param  \App\Models\Fichiers\Activites  $activite
     * @return void
     */
    public function restored(Activites $activite)
    {
        //
    }

    /**
     * Handle the activites "force deleted" event.
     *
     * @param  \App\Models\Fichiers\Activites  $activite
     * @return void
     */
    public function forceDeleted(Activites $activite)
    {
        //
    }
}
