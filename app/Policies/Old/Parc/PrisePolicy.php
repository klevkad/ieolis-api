<?php

namespace App\Policies\Old\Parc;

use App\Models\Old\Parc\Prise;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrisePolicy
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
        return $user->hasPermissionTo('priseindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Prise  $prise
     * @return mixed
     */
    public function view(User $user, Prise $prise)
    {
        return $user->hasPermissionTo('priseshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('prisecreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Prise  $prise
     * @return mixed
     */
    public function update(User $user, Prise $prise)
    {
        return $user->hasPermissionTo('priseupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fichiers\Prise  $prise
     * @return mixed
     */
    public function delete(User $user, Prise $prise)
    {
        return $user->hasPermissionTo('prisedelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Prise  $prise
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Prise $prise)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Parc\Prise  $prise
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Prise $prise)
    {
        //
    }
}
