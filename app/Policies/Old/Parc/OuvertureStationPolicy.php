<?php

namespace App\Policies\Old\Parc;

use App\Models\Old\Parc\OuvertureStation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OuvertureStationPolicy
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
        return $user->hasPermissionTo('ouverturestationindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\OuvertureStation  $OuvertureStation
     * @return mixed
     */
    public function view(User $user, OuvertureStation $OuvertureStation)
    {
        return $user->hasPermissionTo('ouverturestationshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('ouverturestationcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\OuvertureStation  $OuvertureStation
     * @return mixed
     */
    public function update(User $user, OuvertureStation $OuvertureStation)
    {
        return $user->hasPermissionTo('ouverturestationupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\OuvertureStation  $OuvertureStation
     * @return mixed
     */
    public function delete(User $user, OuvertureStation $OuvertureStation)
    {
        return $user->hasPermissionTo('ouverturestationdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\OuvertureStation  $OuvertureStation
     * @return mixed
     */
    public function restore(User $user, OuvertureStation $OuvertureStation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\OuvertureStation  $OuvertureStation
     * @return mixed
     */
    public function forceDelete(User $user, OuvertureStation $OuvertureStation)
    {
        //
    }

}
