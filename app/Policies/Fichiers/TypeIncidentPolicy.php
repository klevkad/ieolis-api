<?php

namespace App\Policies\Fichiers;

use App\Models\Fichiers\TypeIncident;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TypeIncidentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('typeincidentindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\TypeIncident  $typeIncident
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, TypeIncident $typeIncident)
    {
        return $user->hasPermissionTo('typeincidentshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('typeincidentcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\TypeIncident  $typeIncident
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TypeIncident $typeIncident)
    {
        return $user->hasPermissionTo('typeincidentupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\TypeIncident  $typeIncident
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TypeIncident $typeIncident)
    {
        return $user->hasPermissionTo('typeincidentdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\TypeIncident  $typeIncident
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TypeIncident $typeIncident)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\TypeIncident  $typeIncident
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, TypeIncident $typeIncident)
    {
        //
    }
}
