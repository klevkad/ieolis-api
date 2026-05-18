<?php

namespace App\Policies\Export;

use App\Models\Export\EmbarquementTc;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmbarquementTcPolicy
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
        return $user->hasPermissionTo('embarquementtcindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\EmbarquementTc  $embarquementTc
     * @return mixed
     */
    public function view(User $user, EmbarquementTc $embarquementTc)
    {
        return $user->hasPermissionTo('embarquementtcshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('embarquementtccreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\EmbarquementTc  $embarquementTc
     * @return mixed
     */
    public function update(User $user, EmbarquementTc $embarquementTc)
    {
        return $user->hasPermissionTo('embarquementtcupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\EmbarquementTc  $embarquementTc
     * @return mixed
     */
    public function delete(User $user, EmbarquementTc $embarquementTc)
    {
        return $user->hasPermissionTo('embarquementtcdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\EmbarquementTc  $embarquementTc
     * @return mixed
     */
    public function restore(User $user, EmbarquementTc $embarquementTc)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\EmbarquementTc  $embarquementTc
     * @return mixed
     */
    public function forceDelete(User $user, EmbarquementTc $embarquementTc)
    {
        //
    }
}
