<?php

namespace App\Observers\Export;

use App\Models\Export\PositionnementTcPropreMoyen;
use App\Traits\HasUserstamps;

class PositionnementTcPropreMoyenObserver
{
    use HasUserstamps;
    
    /**
     * Handle the positionnement tc propre moyen "created" event.
     *
     * @param  \App\Models\Export\PositionnementTcPropreMoyen  $positionnementTcPropreMoyen
     * @return void
     */
    public function created(PositionnementTcPropreMoyen $positionnementTcPropreMoyen)
    {
        //
    }

    /**
     * Handle the positionnement tc propre moyen "updated" event.
     *
     * @param  \App\Models\Export\PositionnementTcPropreMoyen  $positionnementTcPropreMoyen
     * @return void
     */
    public function updated(PositionnementTcPropreMoyen $positionnementTcPropreMoyen)
    {
        //
    }

    /**
     * Handle the positionnement tc propre moyen "deleted" event.
     *
     * @param  \App\Models\Export\PositionnementTcPropreMoyen  $positionnementTcPropreMoyen
     * @return void
     */
    public function deleted(PositionnementTcPropreMoyen $positionnementTcPropreMoyen)
    {
        //
    }

    /**
     * Handle the positionnement tc propre moyen "restored" event.
     *
     * @param  \App\Models\Export\PositionnementTcPropreMoyen  $positionnementTcPropreMoyen
     * @return void
     */
    public function restored(PositionnementTcPropreMoyen $positionnementTcPropreMoyen)
    {
        //
    }

    /**
     * Handle the positionnement tc propre moyen "force deleted" event.
     *
     * @param  \App\Models\Export\PositionnementTcPropreMoyen  $positionnementTcPropreMoyen
     * @return void
     */
    public function forceDeleted(PositionnementTcPropreMoyen $positionnementTcPropreMoyen)
    {
        //
    }
}
