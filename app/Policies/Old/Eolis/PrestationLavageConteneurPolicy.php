<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\Prestation_Lavage_Conteneur;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrestationLavageConteneurPolicy
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
        return $user->hasPermissionTo('prestationlavageconteneurindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Lavage_Conteneur  $prestation_lavage_conteneur
     * @return mixed
     */
    public function view(User $user, Prestation_Lavage_Conteneur $prestation_lavage_conteneur)
    {
        return $user->hasPermissionTo('prestationlavageconteneurshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('prestationlavageconteneurcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Lavage_Conteneur  $prestation_lavage_conteneur
     * @return mixed
     */
    public function update(User $user, Prestation_Lavage_Conteneur $prestation_lavage_conteneur)
    {
        return $user->hasPermissionTo('prestationlavageconteneurupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Lavage_Conteneur  $prestation_lavage_conteneur
     * @return mixed
     */
    public function delete(User $user, Prestation_Lavage_Conteneur $prestation_lavage_conteneur)
    {
        return $user->hasPermissionTo('prestationlavageconteneurdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Lavage_Conteneur  $prestation_lavage_conteneur
     * @return mixed
     */
    public function restore(User $user, Prestation_Lavage_Conteneur $prestation_lavage_conteneur)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Lavage_Conteneur  $prestation_lavage_conteneur
     * @return mixed
     */
    public function forceDelete(User $user, Prestation_Lavage_Conteneur $prestation_lavage_conteneur)
    {
        //
    }
}
