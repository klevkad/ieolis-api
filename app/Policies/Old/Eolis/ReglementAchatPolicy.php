<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\Reglement_Achat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReglementAchatPolicy
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
        return $user->hasPermissionTo('reglementachatindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Reglement_Achat  $reglementAchat
     * @return mixed
     */
    public function view(User $user, Reglement_Achat $reglementAchat)
    {
        return $user->hasPermissionTo('reglementachatshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('reglementachatcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Reglement_Achat  $reglementAchat
     * @return mixed
     */
    public function update(User $user, Reglement_Achat $reglementAchat)
    {
        return $user->hasPermissionTo('reglementachatupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Reglement_Achat  $reglementAchat
     * @return mixed
     */
    public function delete(User $user, Reglement_Achat $reglementAchat)
    {
        return $user->hasPermissionTo('reglementachatdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Reglement_Achat  $reglementAchat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Reglement_Achat $reglementAchat)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Reglement_Achat  $reglementAchat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Reglement_Achat $reglementAchat)
    {
        //
    }

}
