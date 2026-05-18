<?php

namespace App\Observers\Old\Parc;

use App\Models\Old\Parc\BatterieEtat;

class BatterieEtatObserver
{
    /**
     * Handle the BatterieEtat "created" event.
     *
     * @param  \App\Models\Old\Parc\BatterieEtat  $batterieEtat
     * @return void
     */
    public function created(BatterieEtat $batterieEtat)
    {
        //
    }

    /**
     * Handle the BatterieEtat "updated" event.
     *
     * @param  \App\Models\Old\Parc\BatterieEtat  $batterieEtat
     * @return void
     */
    public function updated(BatterieEtat $batterieEtat)
    {
        //
    }

    /**
     * Handle the BatterieEtat "deleted" event.
     *
     * @param  \App\Models\Old\Parc\BatterieEtat  $batterieEtat
     * @return void
     */
    public function deleted(BatterieEtat $batterieEtat)
    {
        //
    }

    /**
     * Handle the BatterieEtat "restored" event.
     *
     * @param  \App\Models\Old\Parc\BatterieEtat  $batterieEtat
     * @return void
     */
    public function restored(BatterieEtat $batterieEtat)
    {
        //
    }

    /**
     * Handle the BatterieEtat "force deleted" event.
     *
     * @param  \App\Models\Old\Parc\BatterieEtat  $batterieEtat
     * @return void
     */
    public function forceDeleted(BatterieEtat $batterieEtat)
    {
        //
    }
}
