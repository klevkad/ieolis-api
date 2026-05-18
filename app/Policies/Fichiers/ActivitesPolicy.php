<?php

namespace App\Policies\Fichiers;

use App\Models\Fichiers\Activites;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivitesPolicy
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
        return $user->hasPermissionTo('activitesindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Activites  $activite
     * @return mixed
     */
    public function view(User $user, Activites $activite)
    {
        return $user->hasPermissionTo('activitesshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('activitescreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Activites  $activite
     * @return mixed
     */
    public function update(User $user, Activites $activite)
    {
        return $user->hasPermissionTo('activitesupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Activites  $activite
     * @return mixed
     */
    public function delete(User $user, Activites $activite)
    {
        return $user->hasPermissionTo('activitesdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Activites  $activite
     * @return mixed
     */
    public function restore(User $user, Activites $activite)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Activites  $activite
     * @return mixed
     */
    public function forceDelete(User $user, Activites $activite)
    {
        //
    }
}
