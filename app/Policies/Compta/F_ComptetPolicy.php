<?php

namespace App\Policies\Compta;

use App\Models\Compta\F_Comptet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class F_ComptetPolicy
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
        return $user->hasPermissionTo('fcomptetindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Compta\F_Comptet  $fComptet
     * @return mixed
     */
    public function view(User $user, F_Comptet $fComptet)
    {
        return $user->hasPermissionTo('fcomptetshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('fcomptetcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Compta\F_Comptet  $fComptet
     * @return mixed
     */
    public function update(User $user, F_Comptet $fComptet)
    {
        return $user->hasPermissionTo('fcomptetupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Compta\F_Comptet  $fComptet
     * @return mixed
     */
    public function delete(User $user, F_Comptet $fComptet)
    {
        return $user->hasPermissionTo('fcomptetdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Compta\F_Comptet  $fComptet
     * @return mixed
     */
    public function restore(User $user, F_Comptet $fComptet)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Compta\F_Comptet  $fComptet
     * @return mixed
     */
    public function forceDelete(User $user, F_Comptet $fComptet)
    {
        //
    }
}
