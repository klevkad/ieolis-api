<?php

namespace App\Observers\Engins;

use App\Models\Engins\ApproCarburant;
use App\Traits\HasUserstamps;

class ApproCarburantObserver
{
    use HasUserstamps;
    
    /**
     * Handle the ApproCarburant "created" event.
     *
     * @param  \App\Models\Engins\ApproCarburant  $approCarburant
     * @return void
     */
    public function created(ApproCarburant $approCarburant)
    {
        //
    }

    /**
     * Handle the ApproCarburant "updated" event.
     *
     * @param  \App\Models\Engins\ApproCarburant  $approCarburant
     * @return void
     */
    public function updated(ApproCarburant $approCarburant)
    {
        //
    }

    /**
     * Handle the ApproCarburant "deleted" event.
     *
     * @param  \App\Models\Engins\ApproCarburant  $approCarburant
     * @return void
     */
    public function deleted(ApproCarburant $approCarburant)
    {
        //
    }

    /**
     * Handle the ApproCarburant "restored" event.
     *
     * @param  \App\Models\Engins\ApproCarburant  $approCarburant
     * @return void
     */
    public function restored(ApproCarburant $approCarburant)
    {
        //
    }

    /**
     * Handle the ApproCarburant "force deleted" event.
     *
     * @param  \App\Models\Engins\ApproCarburant  $approCarburant
     * @return void
     */
    public function forceDeleted(ApproCarburant $approCarburant)
    {
        //
    }
}
