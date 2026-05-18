<?php

namespace App\Policies\Old\Parc;

use App\Models\Old\Parc\Batterie;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BatteriePolicy
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
        return $user->hasPermissionTo('batterieindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Batterie  $batterie
     * @return mixed
     */
    public function view(User $user, Batterie $batterie)
    {
        return $user->hasPermissionTo('batterieshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('batteriecreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Batterie  $batterie
     * @return mixed
     */
    public function update(User $user, Batterie $batterie)
    {
        return $user->hasPermissionTo('batterieupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Batterie  $batterie
     * @return mixed
     */
    public function delete(User $user, Batterie $batterie)
    {
        return $user->hasPermissionTo('batteriedelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Batterie  $batterie
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Batterie $batterie)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Batterie  $batterie
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Batterie $batterie)
    {
        //
    }
}
