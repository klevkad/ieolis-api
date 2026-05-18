<?php

namespace App\Observers\Old\Parc;

use App\Models\Old\Parc\SignalPanne;
use App\Traits\HasUserstamps;

class SignalPanneObserver
{
    use HasUserstamps;

    /**
     * Handle the SignalPanne "created" event.
     *
     * @param  \App\Models\Old\Parc\SignalPanne  $signalPanne
     * @return void
     */
    public function created(SignalPanne $signalPanne)
    {
        //
    }

    /**
     * Handle the SignalPanne "updated" event.
     *
     * @param  \App\Models\Old\Parc\SignalPanne  $signalPanne
     * @return void
     */
    public function updated(SignalPanne $signalPanne)
    {
        //
    }

    /**
     * Handle the SignalPanne "deleted" event.
     *
     * @param  \App\Models\Old\Parc\SignalPanne  $signalPanne
     * @return void
     */
    public function deleted(SignalPanne $signalPanne)
    {
        //
    }

    /**
     * Handle the SignalPanne "restored" event.
     *
     * @param  \App\Models\Old\Parc\SignalPanne  $signalPanne
     * @return void
     */
    public function restored(SignalPanne $signalPanne)
    {
        //
    }

    /**
     * Handle the SignalPanne "force deleted" event.
     *
     * @param  \App\Models\Old\Parc\SignalPanne  $signalPanne
     * @return void
     */
    public function forceDeleted(SignalPanne $signalPanne)
    {
        //
    }
}
