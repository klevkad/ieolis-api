<?php

namespace App\Observers\Old\Parc;

use App\Models\Old\Parc\Prise;
use App\Traits\HasUserstamps;

class PriseObserver
{
    use HasUserstamps;

    /**
     * Handle the Prise "created" event.
     *
     * @param  \App\Models\Old\Parc\Prise  $prise
     * @return void
     */
    public function created(Prise $prise)
    {
        //
    }

    /**
     * Handle the Prise "updated" event.
     *
     * @param  \App\Models\Old\Parc\Prise  $prise
     * @return void
     */
    public function updated(Prise $prise)
    {
        //
    }

    /**
     * Handle the Prise "deleted" event.
     *
     * @param  \App\Models\Old\Parc\Prise  $prise
     * @return void
     */
    public function deleted(Prise $prise)
    {
        //
    }

    /**
     * Handle the Prise "restored" event.
     *
     * @param  \App\Models\Old\Parc\Prise  $prise
     * @return void
     */
    public function restored(Prise $prise)
    {
        //
    }

    /**
     * Handle the Prise "force deleted" event.
     *
     * @param  \App\Models\Old\Parc\Prise  $prise
     * @return void
     */
    public function forceDeleted(Prise $prise)
    {
        //
    }
}
