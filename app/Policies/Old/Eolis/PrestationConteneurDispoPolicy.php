<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\Prestation_Conteneur_Dispo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrestationConteneurDispoPolicy
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
        return $user->hasPermissionTo('prestationconteneurdispoindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Conteneur_Dispo  $prestation_conteneur_dispo
     * @return mixed
     */
    public function view(User $user, Prestation_Conteneur_Dispo $prestation_conteneur_dispo)
    {
        return $user->hasPermissionTo('prestationconteneurdisposhow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('prestationconteneurdispocreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Conteneur_Dispo  $prestation_conteneur_dispo
     * @return mixed
     */
    public function update(User $user, Prestation_Conteneur_Dispo $prestation_conteneur_dispo)
    {
        return $user->hasPermissionTo('prestationconteneurdispoupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Conteneur_Dispo  $prestation_conteneur_dispo
     * @return mixed
     */
    public function delete(User $user, Prestation_Conteneur_Dispo $prestation_conteneur_dispo)
    {
        return $user->hasPermissionTo('prestationconteneurdispodelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Conteneur_Dispo  $prestation_conteneur_dispo
     * @return mixed
     */
    public function restore(User $user, Prestation_Conteneur_Dispo $prestation_conteneur_dispo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Prestation_Conteneur_Dispo  $prestation_conteneur_dispo
     * @return mixed
     */
    public function forceDelete(User $user, Prestation_Conteneur_Dispo $prestation_conteneur_dispo)
    {
        //
    }
}
