<?php

namespace App\Policies\Export;

use App\Models\Export\EmpotageTcPosit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmpotageTcPositPolicy
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
        return $user->hasPermissionTo('empotagetcpositindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\EmpotageTcPosit  $empotageTcPosit
     * @return mixed
     */
    public function view(User $user, EmpotageTcPosit $empotageTcPosit)
    {
        return $user->hasPermissionTo('empotagetcpositshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('empotagetcpositcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\EmpotageTcPosit  $empotageTcPosit
     * @return mixed
     */
    public function update(User $user, EmpotageTcPosit $empotageTcPosit)
    {
        return $user->hasPermissionTo('empotagetcpositupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\EmpotageTcPosit  $empotageTcPosit
     * @return mixed
     */
    public function delete(User $user, EmpotageTcPosit $empotageTcPosit)
    {
        return $user->hasPermissionTo('empotagetcpositdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\EmpotageTcPosit  $empotageTcPosit
     * @return mixed
     */
    public function restore(User $user, EmpotageTcPosit $empotageTcPosit)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\EmpotageTcPosit  $empotageTcPosit
     * @return mixed
     */
    public function forceDelete(User $user, EmpotageTcPosit $empotageTcPosit)
    {
        //
    }
}
