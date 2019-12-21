<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Determine whether the user can view the supplier.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function read(User $user)
    {
        $per = User::getUserPrivileges('product');

        return $per->read == 1 ? true : false;
    }

    /**
     * Determine whether the user can create suppliers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $per = User::getUserPrivileges('product');

        return $per->create == 1 ? true : false;
    }

    /**
     * Determine whether the user can update the supplier.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function update(User $user)
    {
        $per = User::getUserPrivileges('product');

        return $per->update == 1 ? true : false;
    }

    /**
     * Determine whether the user can delete the supplier.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function delete(User $user)
    {
        $per = User::getUserPrivileges('product');

        return $per->delete == 1 ? true : false;
    }
}
