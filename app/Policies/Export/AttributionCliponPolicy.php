<?php

namespace App\Policies\Export;

use App\Models\Export\AttributionClipon;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributionCliponPolicy
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
        return $user->hasPermissionTo('attributioncliponindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionClipon  $attributionClipon
     * @return mixed
     */
    public function view(User $user, AttributionClipon $attributionClipon)
    {
        return $user->hasPermissionTo('attributioncliponshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('attributioncliponcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionClipon  $attributionClipon
     * @return mixed
     */
    public function update(User $user, AttributionClipon $attributionClipon)
    {
        return $user->hasPermissionTo('attributioncliponupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionClipon  $attributionClipon
     * @return mixed
     */
    public function delete(User $user, AttributionClipon $attributionClipon)
    {
        return $user->hasPermissionTo('attributionclipondelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionClipon  $attributionClipon
     * @return mixed
     */
    public function restore(User $user, AttributionClipon $attributionClipon)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Export\AttributionClipon  $attributionClipon
     * @return mixed
     */
    public function forceDelete(User $user, AttributionClipon $attributionClipon)
    {
        //
    }
}
