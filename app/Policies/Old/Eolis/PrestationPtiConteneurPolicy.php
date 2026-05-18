<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\Prestation_Pti_Conteneur;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrestationPtiConteneurPolicy
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
        return $user->hasPermissionTo('prestationpticonteneurindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Pti_Conteneur  $prestation_pti_conteneur
     * @return mixed
     */
    public function view(User $user, Prestation_Pti_Conteneur $prestation_pti_conteneur)
    {
        return $user->hasPermissionTo('prestationpticonteneurshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('prestationpticonteneurcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Pti_Conteneur  $prestation_pti_conteneur
     * @return mixed
     */
    public function update(User $user, Prestation_Pti_Conteneur $prestation_pti_conteneur)
    {
        return $user->hasPermissionTo('prestationpticonteneurupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Pti_Conteneur  $prestation_pti_conteneur
     * @return mixed
     */
    public function delete(User $user, Prestation_Pti_Conteneur $prestation_pti_conteneur)
    {
        return $user->hasPermissionTo('prestationpticonteneurdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Pti_Conteneur  $prestation_pti_conteneur
     * @return mixed
     */
    public function restore(User $user, Prestation_Pti_Conteneur $prestation_pti_conteneur)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Pti_Conteneur  $prestation_pti_conteneur
     * @return mixed
     */
    public function forceDelete(User $user, Prestation_Pti_Conteneur $prestation_pti_conteneur)
    {
        //
    }
}
