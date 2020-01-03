<?php

namespace App\Policies;

use App\Supplier;
use App\User;
use App\UAuth;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupplierPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view the supplier.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function read(User $user)
    {
        $per = UAuth::getUserPrivileges('supplier');

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
        $per = UAuth::getUserPrivileges('supplier');

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
        $per = UAuth::getUserPrivileges('supplier');

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
        $per = UAuth::getUserPrivileges('supplier');

        return $per->delete == 1 ? true : false;
    }


}
