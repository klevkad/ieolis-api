<?php

namespace App\Observers\Export;

use App\Models\Export\EmpotageTcPosit;
use App\Traits\HasUserstamps;

class EmpotageTcPositObserver
{
    use HasUserstamps;
    
    /**
     * Handle the empotage tc posit "created" event.
     *
     * @param  \App\Models\Export\EmpotageTcPosit  $empotageTcPosit
     * @return void
     */
    public function created(EmpotageTcPosit $empotageTcPosit)
    {
        //
    }

    /**
     * Handle the empotage tc posit "updated" event.
     *
     * @param  \App\Models\Export\EmpotageTcPosit  $empotageTcPosit
     * @return void
     */
    public function updated(EmpotageTcPosit $empotageTcPosit)
    {
        //
    }

    /**
     * Handle the empotage tc posit "deleted" event.
     *
     * @param  \App\Models\Export\EmpotageTcPosit  $empotageTcPosit
     * @return void
     */
    public function deleted(EmpotageTcPosit $empotageTcPosit)
    {
        //
    }

    /**
     * Handle the empotage tc posit "restored" event.
     *
     * @param  \App\Models\Export\EmpotageTcPosit  $empotageTcPosit
     * @return void
     */
    public function restored(EmpotageTcPosit $empotageTcPosit)
    {
        //
    }

    /**
     * Handle the empotage tc posit "force deleted" event.
     *
     * @param  \App\Models\Export\EmpotageTcPosit  $empotageTcPosit
     * @return void
     */
    public function forceDeleted(EmpotageTcPosit $empotageTcPosit)
    {
        //
    }
}
