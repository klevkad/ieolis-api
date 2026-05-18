<?php

namespace App\Observers\Fichiers;

use App\Models\Fichiers\StationEmpotage;
use App\Traits\HasUserstamps;

class StationEmpotageObserver
{
    use HasUserstamps;
    
    /**
     * Handle the station empotage "created" event.
     *
     * @param  \App\Models\Fichiers\StationEmpotage  $stationEmpotage
     * @return void
     */
    public function created(StationEmpotage $stationEmpotage)
    {
        //
    }

    /**
     * Handle the station empotage "updated" event.
     *
     * @param  \App\Models\Fichiers\StationEmpotage  $stationEmpotage
     * @return void
     */
    public function updated(StationEmpotage $stationEmpotage)
    {
        //
    }

    /**
     * Handle the station empotage "deleted" event.
     *
     * @param  \App\Models\Fichiers\StationEmpotage  $stationEmpotage
     * @return void
     */
    public function deleted(StationEmpotage $stationEmpotage)
    {
        //
    }

    /**
     * Handle the station empotage "restored" event.
     *
     * @param  \App\Models\Fichiers\StationEmpotage  $stationEmpotage
     * @return void
     */
    public function restored(StationEmpotage $stationEmpotage)
    {
        //
    }

    /**
     * Handle the station empotage "force deleted" event.
     *
     * @param  \App\Models\Fichiers\StationEmpotage  $stationEmpotage
     * @return void
     */
    public function forceDeleted(StationEmpotage $stationEmpotage)
    {
        //
    }
}
