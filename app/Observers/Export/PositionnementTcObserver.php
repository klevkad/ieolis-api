<?php

namespace App\Observers\Export;

use App\Models\Export\PositionnementTc;
use App\Traits\HasUserstamps;

class PositionnementTcObserver
{
    use HasUserstamps;
    
    /**
     * Handle the positionnement tc "created" event.
     *
     * @param  \App\Models\Export\PositionnementTc  $positionnementTc
     * @return void
     */
    public function created(PositionnementTc $positionnementTc)
    {
        //
    }

    /**
     * Handle the positionnement tc "updated" event.
     *
     * @param  \App\Models\Export\PositionnementTc  $positionnementTc
     * @return void
     */
    public function updated(PositionnementTc $positionnementTc)
    {
        //
    }

    /**
     * Handle the positionnement tc "deleted" event.
     *
     * @param  \App\Models\Export\PositionnementTc  $positionnementTc
     * @return void
     */
    public function deleted(PositionnementTc $positionnementTc)
    {
        //
    }

    /**
     * Handle the positionnement tc "restored" event.
     *
     * @param  \App\Models\Export\PositionnementTc  $positionnementTc
     * @return void
     */
    public function restored(PositionnementTc $positionnementTc)
    {
        //
    }

    /**
     * Handle the positionnement tc "force deleted" event.
     *
     * @param  \App\Models\Export\PositionnementTc  $positionnementTc
     * @return void
     */
    public function forceDeleted(PositionnementTc $positionnementTc)
    {
        //
    }
}
