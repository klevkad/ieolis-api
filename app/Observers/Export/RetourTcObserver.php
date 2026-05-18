<?php

namespace App\Observers\Export;

use App\Models\Export\RetourTc;
use App\Traits\HasUserstamps;

class RetourTcObserver
{
    use HasUserstamps;
    
    /**
     * Handle the retour tc "created" event.
     *
     * @param  \App\Models\Export\RetourTc  $retourTc
     * @return void
     */
    public function created(RetourTc $retourTc)
    {
        //
    }

    /**
     * Handle the retour tc "updated" event.
     *
     * @param  \App\Models\Export\RetourTc  $retourTc
     * @return void
     */
    public function updated(RetourTc $retourTc)
    {
        //
    }

    /**
     * Handle the retour tc "deleted" event.
     *
     * @param  \App\Models\Export\RetourTc  $retourTc
     * @return void
     */
    public function deleted(RetourTc $retourTc)
    {
        //
    }

    /**
     * Handle the retour tc "restored" event.
     *
     * @param  \App\Models\Export\RetourTc  $retourTc
     * @return void
     */
    public function restored(RetourTc $retourTc)
    {
        //
    }

    /**
     * Handle the retour tc "force deleted" event.
     *
     * @param  \App\Models\Export\RetourTc  $retourTc
     * @return void
     */
    public function forceDeleted(RetourTc $retourTc)
    {
        //
    }
}
