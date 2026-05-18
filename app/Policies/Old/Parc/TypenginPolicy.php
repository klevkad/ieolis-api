<?php

namespace App\Policies\Old\Parc;

use App\Models\Old\Parc\Typengin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TypenginPolicy
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
        return $user->hasPermissionTo('typenginindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Typengin  $typengin
     * @return mixed
     */
    public function view(User $user, Typengin $typengin)
    {
        return $user->hasPermissionTo('typenginshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('typengincreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Typengin  $typengin
     * @return mixed
     */
    public function update(User $user, Typengin $typengin)
    {
        return $user->hasPermissionTo('typenginupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Typengin  $typengin
     * @return mixed
     */
    public function delete(User $user, Typengin $typengin)
    {
        return $user->hasPermissionTo('typengindelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Typtypengin  $typtypengin
     * @return mixed
     */
    public function restore(User $user, Typengin $typengin)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Typtypengin  $typtypengin
     * @return mixed
     */
    public function forceDelete(User $user, Typengin $typengin)
    {
        //
    }
}
