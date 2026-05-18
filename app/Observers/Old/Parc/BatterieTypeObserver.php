<?php

namespace App\Observers\Old\Parc;

use App\Models\Old\Parc\BatterieType;

class BatterieTypeObserver
{
    /**
     * Handle the BatterieType "created" event.
     *
     * @param  \App\Models\Old\Parc\BatterieType  $batterieType
     * @return void
     */
    public function created(BatterieType $batterieType)
    {
        //
    }

    /**
     * Handle the BatterieType "updated" event.
     *
     * @param  \App\Models\Old\Parc\BatterieType  $batterieType
     * @return void
     */
    public function updated(BatterieType $batterieType)
    {
        //
    }

    /**
     * Handle the BatterieType "deleted" event.
     *
     * @param  \App\Models\Old\Parc\BatterieType  $batterieType
     * @return void
     */
    public function deleted(BatterieType $batterieType)
    {
        //
    }

    /**
     * Handle the BatterieType "restored" event.
     *
     * @param  \App\Models\Old\Parc\BatterieType  $batterieType
     * @return void
     */
    public function restored(BatterieType $batterieType)
    {
        //
    }

    /**
     * Handle the BatterieType "force deleted" event.
     *
     * @param  \App\Models\Old\Parc\BatterieType  $batterieType
     * @return void
     */
    public function forceDeleted(BatterieType $batterieType)
    {
        //
    }
}
