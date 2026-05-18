<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\Compte_Tiers;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompteTierPolicy
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
        return $user->hasPermissionTo('comptetierindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Compte_Tiers  $compteTier
     * @return mixed
     */
    public function view(User $user, Compte_Tiers $compteTier)
    {
        return $user->hasPermissionTo('comptetiershow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('comptetiercreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Compte_Tiers  $compteTier
     * @return mixed
     */
    public function update(User $user, Compte_Tiers $compteTier)
    {
        return $user->hasPermissionTo('comptetierupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\Compte_Tiers  $compteTier
     * @return mixed
     */
    public function delete(User $user, Compte_Tiers $compteTier)
    {
        return $user->hasPermissionTo('comptetierdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Compte_Tiers  $compteTier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Compte_Tiers $compteTier)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Compte_Tiers  $compteTier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Compte_Tiers $compteTier)
    {
        //
    }

}
