<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\A_Tcsdeb;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class A_TcsdebPolicy
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
        return $user->hasPermissionTo('atcsdebindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\A_Tcsdeb  $a_tcsdeb
     * @return mixed
     */
    public function view(User $user, A_Tcsdeb $a_tcsdeb)
    {
        return $user->hasPermissionTo('atcsdebshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('atcsdebcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\A_Tcsdeb  $a_tcsdeb
     * @return mixed
     */
    public function update(User $user, A_Tcsdeb $a_tcsdeb)
    {
        return $user->hasPermissionTo('atcsdebupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\A_Tcsdeb  $a_tcsemb
     * @return mixed
     */
    public function delete(User $user, A_Tcsdeb $a_tcseb)
    {
        return $user->hasPermissionTo('atcsdebdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\A_Tcsdeb  $a_tcsdeb
     * @return mixed
     */
    public function restore(User $user, A_Tcsdeb $a_tcsdeb)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\A_Tcsdeb  $a_tcsdeb
     * @return mixed
     */
    public function forceDelete(User $user, A_Tcsdeb $a_tcsdeb)
    {
        //
    }
}
