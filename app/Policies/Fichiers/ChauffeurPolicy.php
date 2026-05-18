<?php

namespace App\Policies\Fichiers;

use App\Models\Fichiers\Chauffeur;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChauffeurPolicy
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
        return $user->hasPermissionTo('chauffeurindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Chauffeur  $chauffeur
     * @return mixed
     */
    public function view(User $user, Chauffeur $chauffeur)
    {
        return $user->hasPermissionTo('chauffeurshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('chauffeurcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Chauffeur  $chauffeur
     * @return mixed
     */
    public function update(User $user, Chauffeur $chauffeur)
    {
        return $user->hasPermissionTo('chauffeurupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Chauffeur  $chauffeur
     * @return mixed
     */
    public function delete(User $user, Chauffeur $chauffeur)
    {
        return $user->hasPermissionTo('chauffeurdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Chauffeur  $chauffeur
     * @return mixed
     */
    public function restore(User $user, Chauffeur $chauffeur)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Chauffeur  $chauffeur
     * @return mixed
     */
    public function forceDelete(User $user, Chauffeur $chauffeur)
    {
        //
    }
}
