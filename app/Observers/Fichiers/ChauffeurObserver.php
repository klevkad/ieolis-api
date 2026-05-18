<?php

namespace App\Observers\Fichiers;

use App\Models\Fichiers\Chauffeur;
use App\Traits\HasUserstamps;

class ChauffeurObserver
{
    use HasUserstamps;
    
    /**
     * Handle the chauffeur "created" event.
     *
     * @param  \App\Models\Fichiers\Chauffeur  $chauffeur
     * @return void
     */
    public function created(Chauffeur $chauffeur)
    {
        //
    }

    /**
     * Handle the chauffeur "updated" event.
     *
     * @param  \App\Models\Fichiers\Chauffeur  $chauffeur
     * @return void
     */
    public function updated(Chauffeur $chauffeur)
    {
        //
    }

    /**
     * Handle the chauffeur "deleted" event.
     *
     * @param  \App\Models\Fichiers\Chauffeur  $chauffeur
     * @return void
     */
    public function deleted(Chauffeur $chauffeur)
    {
        //
    }

    /**
     * Handle the chauffeur "restored" event.
     *
     * @param  \App\Models\Fichiers\Chauffeur  $chauffeur
     * @return void
     */
    public function restored(Chauffeur $chauffeur)
    {
        //
    }

    /**
     * Handle the chauffeur "force deleted" event.
     *
     * @param  \App\Models\Fichiers\Chauffeur  $chauffeur
     * @return void
     */
    public function forceDeleted(Chauffeur $chauffeur)
    {
        //
    }
}
