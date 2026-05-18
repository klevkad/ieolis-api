<?php

namespace App\Policies\Old\Parc;

use App\Models\Old\Parc\BatterieEtat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BatterieEtatPolicy
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
        return $user->hasPermissionTo('batterieetatindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\BatterieEtat  $batterieEtat
     * @return mixed
     */
    public function view(User $user, BatterieEtat $batterieEtat)
    {
        return $user->hasPermissionTo('batterieetatshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('batterieetatcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\BatterieEtat  $batterieEtat
     * @return mixed
     */
    public function update(User $user, BatterieEtat $batterieEtat)
    {
        return $user->hasPermissionTo('batterieetatupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\BatterieEtat  $batterieEtat
     * @return mixed
     */
    public function delete(User $user, BatterieEtat $batterieEtat)
    {
        return $user->hasPermissionTo('batterieetatdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\BatterieEtat  $batterieEtat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, BatterieEtat $batterieEtat)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\BatterieEtat  $batterieEtat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, BatterieEtat $batterieEtat)
    {
        //
    }
}
