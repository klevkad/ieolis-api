<?php

namespace App\Policies\Fichiers;

use App\Models\Fichiers\Transporteur;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransporteurPolicy
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
        return $user->hasPermissionTo('transporteurindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Transporteur  $transporteur
     * @return mixed
     */
    public function view(User $user, Transporteur $transporteur)
    {
        return $user->hasPermissionTo('transporteurshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('transporteurcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Transporteur  $transporteur
     * @return mixed
     */
    public function update(User $user, Transporteur $transporteur)
    {
        return $user->hasPermissionTo('transporteurupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Transporteur  $transporteur
     * @return mixed
     */
    public function delete(User $user, Transporteur $transporteur)
    {
        return $user->hasPermissionTo('transporteurdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Transporteur  $transporteur
     * @return mixed
     */
    public function restore(User $user, Transporteur $transporteur)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Transporteur  $transporteur
     * @return mixed
     */
    public function forceDelete(User $user, Transporteur $transporteur)
    {
        //
    }
}
