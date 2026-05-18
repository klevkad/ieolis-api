<?php

namespace App\Observers\Fichiers;

use App\Models\Fichiers\TypeIncident;
use App\Traits\HasUserstamps;

class TypeIncidentObserver
{
    use HasUserstamps;
    
    /**
     * Handle the TypeIncident "created" event.
     *
     * @param  \App\Models\Fichiers\TypeIncident  $typeIncident
     * @return void
     */
    public function created(TypeIncident $typeIncident)
    {
        //
    }

    /**
     * Handle the TypeIncident "updated" event.
     *
     * @param  \App\Models\Fichiers\TypeIncident  $typeIncident
     * @return void
     */
    public function updated(TypeIncident $typeIncident)
    {
        //
    }

    /**
     * Handle the TypeIncident "deleted" event.
     *
     * @param  \App\Models\Fichiers\TypeIncident  $typeIncident
     * @return void
     */
    public function deleted(TypeIncident $typeIncident)
    {
        //
    }

    /**
     * Handle the TypeIncident "restored" event.
     *
     * @param  \App\Models\Fichiers\TypeIncident  $typeIncident
     * @return void
     */
    public function restored(TypeIncident $typeIncident)
    {
        //
    }

    /**
     * Handle the TypeIncident "force deleted" event.
     *
     * @param  \App\Models\Fichiers\TypeIncident  $typeIncident
     * @return void
     */
    public function forceDeleted(TypeIncident $typeIncident)
    {
        //
    }
}
