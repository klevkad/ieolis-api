<?php

namespace App\Policies\Old\Eolis;

use App\Models\Old\Eolis\Produit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProduitPolicy
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
        return $user->hasPermissionTo('produitindex');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Produit  $produit
     * @return mixed
     */
    public function view(User $user, Produit $produit)
    {
        return $user->hasPermissionTo('produitshow');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('produitcreate');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Produit  $produit
     * @return mixed
     */
    public function update(User $user, Produit $produit)
    {
        return $user->hasPermissionTo('produitupdate');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Produit  $produit
     * @return mixed
     */
    public function delete(User $user, Produit $produit)
    {
        return $user->hasPermissionTo('produitdelete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Produit  $produit
     * @return mixed
     */
    public function restore(User $user, Produit $produit)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Old\Eolis\Produit  $produit
     * @return mixed
     */
    public function forceDelete(User $user, Produit $produit)
    {
        //
    }
}
