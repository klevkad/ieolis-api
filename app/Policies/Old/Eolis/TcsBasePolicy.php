<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\TcsBase;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TcsBasePolicy
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
        return $user->hasPermissionTo('tcsbaseindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\TcsBase  $tcsBase
     * @return mixed
     */
    public function view(User $user, TcsBase $tcsBase)
    {
        return $user->hasPermissionTo('tcsbaseshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('tcsbasecreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\TcsBase  $tcsBase
     * @return mixed
     */
    public function update(User $user, TcsBase $tcsBase)
    {
        return $user->hasPermissionTo('tcsbaseupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\TcsBase  $tcsBase
     * @return mixed
     */
    public function delete(User $user, TcsBase $tcsBase)
    {
        return $user->hasPermissionTo('tcsbasedelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\TcsBase  $tcsBase
     * @return mixed
     */
    public function restore(User $user, TcsBase $tcsBase)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\TcsBase  $tcsBase
     * @return mixed
     */
    public function forceDelete(User $user, TcsBase $tcsBase)
    {
        //
    }
}
