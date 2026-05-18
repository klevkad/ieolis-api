<?php

namespace App\Policies\Old\Parc;

use App\Models\Old\Parc\OT;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OTPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('otindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\OT  $ot
     * @return mixed
     */
    public function view(User $user, OT $ot)
    {
        return $user->hasPermissionTo('otshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('otcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\OT  $ot
     * @return mixed
     */
    public function update(User $user, OT $ot)
    {
        return $user->hasPermissionTo('otupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\OT  $ot
     * @return mixed
     */
    public function delete(User $user, OT $ot)
    {
        return $user->hasPermissionTo('otdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\OT  $oT
     * @return mixed
     */
    public function restore(User $user, OT $oT)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\OT  $oT
     * @return mixed
     */
    public function forceDelete(User $user, OT $oT)
    {
        //
    }
}
