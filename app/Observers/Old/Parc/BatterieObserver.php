<?php

namespace App\Observers\Old\Parc;

use App\Models\Old\Parc\Batterie;
use App\Traits\HasUserstamps;

class BatterieObserver
{
    use HasUserstamps;

    /**
     * Handle the Batterie "created" event.
     *
     * @param  \App\Models\Old\Parc\Batterie  $batterie
     * @return void
     */
    public function created(Batterie $batterie)
    {
        //
    }

    /**
     * Handle the Batterie "updated" event.
     *
     * @param  \App\Models\Old\Parc\Batterie  $batterie
     * @return void
     */
    public function updated(Batterie $batterie)
    {
        //
    }

    /**
     * Handle the Batterie "deleted" event.
     *
     * @param  \App\Models\Old\Parc\Batterie  $batterie
     * @return void
     */
    public function deleted(Batterie $batterie)
    {
        //
    }

    /**
     * Handle the Batterie "restored" event.
     *
     * @param  \App\Models\Old\Parc\Batterie  $batterie
     * @return void
     */
    public function restored(Batterie $batterie)
    {
        //
    }

    /**
     * Handle the Batterie "force deleted" event.
     *
     * @param  \App\Models\Old\Parc\Batterie  $batterie
     * @return void
     */
    public function forceDeleted(Batterie $batterie)
    {
        //
    }
}
