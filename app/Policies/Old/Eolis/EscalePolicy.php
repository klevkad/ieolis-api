<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\Escale;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EscalePolicy
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
        return $user->hasPermissionTo('escaleindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Escale  $escale
     * @return mixed
     */
    public function view(User $user, Escale $escale)
    {
        return $user->hasPermissionTo('escaleshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('escalecreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Escale  $escale
     * @return mixed
     */
    public function update(User $user, Escale $escale)
    {
        return $user->hasPermissionTo('escaleupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Escale  $escale
     * @return mixed
     */
    public function delete(User $user, Escale $escale)
    {
        return $user->hasPermissionTo('escaledelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Escale  $escale
     * @return mixed
     */
    public function restore(User $user, Escale $escale)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Escale  $escale
     * @return mixed
     */
    public function forceDelete(User $user, Escale $escale)
    {
        //
    }
}
