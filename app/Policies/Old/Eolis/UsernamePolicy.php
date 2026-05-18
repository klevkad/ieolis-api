<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\Username;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsernamePolicy
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
        return $user->hasPermissionTo('usernameindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Username  $username
     * @return mixed
     */
    public function view(User $user, Username $username)
    {
        return $user->hasPermissionTo('usernameshow') || $user->model_id == $username->codeuser;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('usernamecreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Username  $username
     * @return mixed
     */
    public function update(User $user, Username $username)
    {
        return $user->hasPermissionTo('usernameupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Username  $username
     * @return mixed
     */
    public function delete(User $user, Username $username)
    {
        return $user->hasPermissionTo('usernamedelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Username  $username
     * @return mixed
     */
    public function restore(User $user, Username $username)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Username  $username
     * @return mixed
     */
    public function forceDelete(User $user, Username $username)
    {
        //
    }
}
