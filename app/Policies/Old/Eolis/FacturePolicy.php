<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\Facture;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FacturePolicy
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
        return $user->hasPermissionTo('factureindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Facture  $facture
     * @return mixed
     */
    public function view(User $user, Facture $facture)
    {
        return $user->hasPermissionTo('factureshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('facturecreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Facture  $facture
     * @return mixed
     */
    public function update(User $user, Facture $facture)
    {
        return $user->hasPermissionTo('factureupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Facture  $facture
     * @return mixed
     */
    public function delete(User $user, Facture $facture)
    {
        return $user->hasPermissionTo('facturedelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Facture  $facture
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Facture $facture)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Facture  $facture
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Facture $facture)
    {
        //
    }

}
