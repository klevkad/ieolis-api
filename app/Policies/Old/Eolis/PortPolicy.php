<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\Port;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortPolicy
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
        return $user->hasPermissionTo('portindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Port  $port
     * @return mixed
     */
    public function view(User $user, Port $port)
    {
        return $user->hasPermissionTo('portshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('portcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Port  $port
     * @return mixed
     */
    public function update(User $user, Port $port)
    {
        return $user->hasPermissionTo('portupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Port  $port
     * @return mixed
     */
    public function delete(User $user, Port $port)
    {
        return $user->hasPermissionTo('portdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Port  $port
     * @return mixed
     */
    public function restore(User $user, Port $port)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Port  $port
     * @return mixed
     */
    public function forceDelete(User $user, Port $port)
    {
        //
    }
}
