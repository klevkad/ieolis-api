<?php

namespace App\Policies\Fichiers;

use App\Models\Fichiers\RLieu;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RLieuPolicy
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
        return $user->hasPermissionTo('rlieuindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\RLieu  $rLieu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, RLieu $rLieu)
    {
        return $user->hasPermissionTo('rlieushow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('rlieucreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\RLieu  $rLieu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, RLieu $rLieu)
    {
        return $user->hasPermissionTo('rlieuupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\RLieu  $rLieu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, RLieu $rLieu)
    {
        return $user->hasPermissionTo('rlieudelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\RLieu  $rLieu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, RLieu $rLieu)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\RLieu  $rLieu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, RLieu $rLieu)
    {
        //
    }
}
