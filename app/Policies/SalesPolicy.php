<?php

namespace App\Policies;

use App\Sale;
use App\User;
use App\UAuth;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesPolicy
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
     * Determine whether the user can view the purchase.
     *
     * @param \App\User $user
     * @param Sale $sale
     * @return mixed
     */
    public function view(User $user, Sale $sale)
    {
        $per = User::getUserPrivileges('sale');

        return $per->read == 1 ? true : false;
    }

    /**
     * Determine whether the user can view the purchase.
     *
     * @param \App\User $user
     * @param Sale $sale
     * @return mixed
     */
    public function read(User $user)
    {

        $per = UAuth::getUserPrivileges('sale');


        return $per->read == 1 ? true : false;
    }

    /**
     * Determine whether the user can create purchases.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        $per = UAuth::getUserPrivileges('sale');

        return $per->create == 1 ? true : false;
    }

    /**
     * Determine whether the user can update the purchase.
     *
     * @param \App\User $user
     * @param Sale $sale
     * @return mixed
     */
    public function update(User $user, Sale $sale)
    {
        $per = UAuth::getUserPrivileges('sale');

        return $per->update == 1 ? true : false;
    }

    /**
     * Determine whether the user can delete the purchase.
     *
     * @param \App\User $user
     * @param Sale $sale
     * @return mixed
     */
    public function delete(User $user, Sale $sale)
    {
        $per = UAuth::getUserPrivileges('sale');

        return $per->delete == 1 ? true : false;
    }

}
