<?php

namespace App\Observers;

use Spatie\Permission\Models\Role;
use App\Traits\HasUserstamps;

class RoleObserver
{
    use HasUserstamps;
    
    /**
     * Handle the role "created" event.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return void
     */
    public function created(Role $role)
    {
        //
    }

    /**
     * Handle the role "updated" event.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return void
     */
    public function updated(Role $role)
    {
        //
    }

    /**
     * Handle the role "deleted" event.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return void
     */
    public function deleted(Role $role)
    {
        //
    }

    /**
     * Handle the role "restored" event.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return void
     */
    public function restored(Role $role)
    {
        //
    }

    /**
     * Handle the role "force deleted" event.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return void
     */
    public function forceDeleted(Role $role)
    {
        //
    }
}
