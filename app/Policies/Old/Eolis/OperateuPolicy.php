<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\Operateu;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OperateuPolicy
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
        return $user->hasPermissionTo('operateuindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Operateu  $operateu
     * @return mixed
     */
    public function view(User $user, Operateu $operateu)
    {
        return $user->hasPermissionTo('operateushow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('operateucreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Operateu  $operateu
     * @return mixed
     */
    public function update(User $user, Operateu $operateu)
    {
        return $user->hasPermissionTo('operateuupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Operateu  $operateu
     * @return mixed
     */
    public function delete(User $user, Operateu $operateu)
    {
        return $user->hasPermissionTo('operateudelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Operateu  $operateu
     * @return mixed
     */
    public function restore(User $user, Operateu $operateu)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Operateu  $operateu
     * @return mixed
     */
    public function forceDelete(User $user, Operateu $operateu)
    {
        //
    }
}
