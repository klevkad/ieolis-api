<?php

namespace App\Policies\Old\Parc;

use App\Models\Old\Parc\Engin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnginPolicy
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
        return $user->hasPermissionTo('enginindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Engin  $engin
     * @return mixed
     */
    public function view(User $user, Engin $engin)
    {
        return $user->hasPermissionTo('enginshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('engincreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Engin  $engin
     * @return mixed
     */
    public function update(User $user, Engin $engin)
    {
        return $user->hasPermissionTo('enginupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Engin  $engin
     * @return mixed
     */
    public function delete(User $user, Engin $engin)
    {
        return $user->hasPermissionTo('engindelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Engin  $engin
     * @return mixed
     */
    public function restore(User $user, Engin $engin)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Engin  $engin
     * @return mixed
     */
    public function forceDelete(User $user, Engin $engin)
    {
        //
    }
}
