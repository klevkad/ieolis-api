<?php

namespace App\Observers\Export;

use App\Models\Export\RetourTcPropreMoyen;
use App\Traits\HasUserstamps;

class RetourTcPropreMoyenObserver
{
    use HasUserstamps;
    
    /**
     * Handle the retour tc propre moyen "created" event.
     *
     * @param  \App\Models\Export\RetourTcPropreMoyen  $retourTcPropreMoyen
     * @return void
     */
    public function created(RetourTcPropreMoyen $retourTcPropreMoyen)
    {
        //
    }

    /**
     * Handle the retour tc propre moyen "updated" event.
     *
     * @param  \App\Models\Export\RetourTcPropreMoyen  $retourTcPropreMoyen
     * @return void
     */
    public function updated(RetourTcPropreMoyen $retourTcPropreMoyen)
    {
        //
    }

    /**
     * Handle the retour tc propre moyen "deleted" event.
     *
     * @param  \App\Models\Export\RetourTcPropreMoyen  $retourTcPropreMoyen
     * @return void
     */
    public function deleted(RetourTcPropreMoyen $retourTcPropreMoyen)
    {
        //
    }

    /**
     * Handle the retour tc propre moyen "restored" event.
     *
     * @param  \App\Models\Export\RetourTcPropreMoyen  $retourTcPropreMoyen
     * @return void
     */
    public function restored(RetourTcPropreMoyen $retourTcPropreMoyen)
    {
        //
    }

    /**
     * Handle the retour tc propre moyen "force deleted" event.
     *
     * @param  \App\Models\Export\RetourTcPropreMoyen  $retourTcPropreMoyen
     * @return void
     */
    public function forceDeleted(RetourTcPropreMoyen $retourTcPropreMoyen)
    {
        //
    }
}
