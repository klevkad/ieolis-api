<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\A_Tcsemb;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class A_TcsembPolicy
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
        return $user->hasPermissionTo('atcsembindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\A_Tcsemb  $a_tcsemb
     * @return mixed
     */
    public function view(User $user, A_Tcsemb $a_tcsemb)
    {
        return $user->hasPermissionTo('atcsembshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('atcsembcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\A_Tcsemb  $a_tcsemb
     * @return mixed
     */
    public function update(User $user, A_Tcsemb $a_tcsemb)
    {
        return $user->hasPermissionTo('atcsembupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\A_Tcsemb  $a_tcsemb
     * @return mixed
     */
    public function delete(User $user, A_Tcsemb $a_tcsemb)
    {
        return $user->hasPermissionTo('atcsembdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\A_Tcsemb  $a_tcsemb
     * @return mixed
     */
    public function restore(User $user, A_Tcsemb $a_tcsemb)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\A_Tcsemb  $a_tcsemb
     * @return mixed
     */
    public function forceDelete(User $user, A_Tcsemb $a_tcsemb)
    {
        //
    }
}
