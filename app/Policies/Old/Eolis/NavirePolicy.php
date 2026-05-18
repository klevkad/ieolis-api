<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\Navire;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NavirePolicy
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
        return $user->hasPermissionTo('navireindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Navire  $navire
     * @return mixed
     */
    public function view(User $user, Navire $navire)
    {
        return $user->hasPermissionTo('navireshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('navirecreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Navire  $navire
     * @return mixed
     */
    public function update(User $user, Navire $navire)
    {
        return $user->hasPermissionTo('navireupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Navire  $navire
     * @return mixed
     */
    public function delete(User $user, Navire $navire)
    {
        return $user->hasPermissionTo('naviredelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Navire  $navire
     * @return mixed
     */
    public function restore(User $user, Navire $navire)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Navire  $navire
     * @return mixed
     */
    public function forceDelete(User $user, Navire $navire)
    {
        //
    }
}
