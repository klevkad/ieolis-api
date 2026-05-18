<?php

namespace App\Policies\Fichiers;

use App\Models\Fichiers\Panne;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PannePolicy
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
        return $user->hasPermissionTo('panneindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Panne  $panne
     * @return mixed
     */
    public function view(User $user, Panne $panne)
    {
        return $user->hasPermissionTo('panneshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('pannecreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Panne  $panne
     * @return mixed
     */
    public function update(User $user, Panne $panne)
    {
        return $user->hasPermissionTo('panneupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Panne  $panne
     * @return mixed
     */
    public function delete(User $user, Panne $panne)
    {
        return $user->hasPermissionTo('pannedelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Panne  $panne
     * @return mixed
     */
    public function restore(User $user, Panne $panne)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Panne  $panne
     * @return mixed
     */
    public function forceDelete(User $user, Panne $panne)
    {
        //
    }
}
