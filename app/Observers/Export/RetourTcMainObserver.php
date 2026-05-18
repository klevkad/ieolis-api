<?php

namespace App\Observers\Export;

use App\Models\Export\RetourTcMain;
use App\Traits\HasUserstamps;

class RetourTcMainObserver
{
    use HasUserstamps;
    
    /**
     * Handle the retour tc main "created" event.
     *
     * @param  \App\Models\Export\RetourTcMain  $retourTcMain
     * @return void
     */
    public function created(RetourTcMain $retourTcMain)
    {
        //
    }

    /**
     * Handle the retour tc main "updated" event.
     *
     * @param  \App\Models\Export\RetourTcMain  $retourTcMain
     * @return void
     */
    public function updated(RetourTcMain $retourTcMain)
    {
        //
    }

    /**
     * Handle the retour tc main "deleted" event.
     *
     * @param  \App\Models\Export\RetourTcMain  $retourTcMain
     * @return void
     */
    public function deleted(RetourTcMain $retourTcMain)
    {
        //
    }

    /**
     * Handle the retour tc main "restored" event.
     *
     * @param  \App\Models\Export\RetourTcMain  $retourTcMain
     * @return void
     */
    public function restored(RetourTcMain $retourTcMain)
    {
        //
    }

    /**
     * Handle the retour tc main "force deleted" event.
     *
     * @param  \App\Models\Export\RetourTcMain  $retourTcMain
     * @return void
     */
    public function forceDeleted(RetourTcMain $retourTcMain)
    {
        //
    }
}
