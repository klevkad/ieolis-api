<?php

namespace App\Observers\Export;

use App\Models\Export\EmbarquementTc;
use App\Traits\HasUserstamps;

class EmbarquementTcObserver
{
    use HasUserstamps;
    
    /**
     * Handle the embarquement tc "created" event.
     *
     * @param  \App\Models\Export\EmbarquementTc  $embarquementTc
     * @return void
     */
    public function created(EmbarquementTc $embarquementTc)
    {
        //
    }

    /**
     * Handle the embarquement tc "updated" event.
     *
     * @param  \App\Models\Export\EmbarquementTc  $embarquementTc
     * @return void
     */
    public function updated(EmbarquementTc $embarquementTc)
    {
        //
    }

    /**
     * Handle the embarquement tc "deleted" event.
     *
     * @param  \App\Models\Export\EmbarquementTc  $embarquementTc
     * @return void
     */
    public function deleted(EmbarquementTc $embarquementTc)
    {
        //
    }

    /**
     * Handle the embarquement tc "restored" event.
     *
     * @param  \App\Models\Export\EmbarquementTc  $embarquementTc
     * @return void
     */
    public function restored(EmbarquementTc $embarquementTc)
    {
        //
    }

    /**
     * Handle the embarquement tc "force deleted" event.
     *
     * @param  \App\Models\Export\EmbarquementTc  $embarquementTc
     * @return void
     */
    public function forceDeleted(EmbarquementTc $embarquementTc)
    {
        //
    }
}
