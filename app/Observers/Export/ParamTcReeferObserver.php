<?php

namespace App\Observers\Export;

use App\Models\Export\ParamTcReefer;
use App\Traits\HasUserstamps;

class ParamTcReeferObserver
{
    use HasUserstamps;
    
    /**
     * Handle the param tc reefer "created" event.
     *
     * @param  \App\Models\Export\ParamTcReefer  $paramTcReefer
     * @return void
     */
    public function created(ParamTcReefer $paramTcReefer)
    {
        //
    }

    /**
     * Handle the param tc reefer "updated" event.
     *
     * @param  \App\Models\Export\ParamTcReefer  $paramTcReefer
     * @return void
     */
    public function updated(ParamTcReefer $paramTcReefer)
    {
        //
    }

    /**
     * Handle the param tc reefer "deleted" event.
     *
     * @param  \App\Models\Export\ParamTcReefer  $paramTcReefer
     * @return void
     */
    public function deleted(ParamTcReefer $paramTcReefer)
    {
        //
    }

    /**
     * Handle the param tc reefer "restored" event.
     *
     * @param  \App\Models\Export\ParamTcReefer  $paramTcReefer
     * @return void
     */
    public function restored(ParamTcReefer $paramTcReefer)
    {
        //
    }

    /**
     * Handle the param tc reefer "force deleted" event.
     *
     * @param  \App\Models\Export\ParamTcReefer  $paramTcReefer
     * @return void
     */
    public function forceDeleted(ParamTcReefer $paramTcReefer)
    {
        //
    }
}
