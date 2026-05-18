<?php

namespace App\Observers;

use Spatie\Permission\Models\Permission;
use App\Traits\HasUserstamps;

class PermissionObserver
{
    use HasUserstamps;
    
    /**
     * Handle the permission "created" event.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return void
     */
    public function created(Permission $permission)
    {
        //
    }

    /**
     * Handle the permission "updated" event.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return void
     */
    public function updated(Permission $permission)
    {
        //
    }

    /**
     * Handle the permission "deleted" event.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return void
     */
    public function deleted(Permission $permission)
    {
        //
    }

    /**
     * Handle the permission "restored" event.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return void
     */
    public function restored(Permission $permission)
    {
        //
    }

    /**
     * Handle the permission "force deleted" event.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return void
     */
    public function forceDeleted(Permission $permission)
    {
        //
    }
}
