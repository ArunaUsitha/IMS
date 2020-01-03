<?php

namespace App\Policies;

use App\User;
use App\UAuth;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsersManagementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function read(User $user)
    {
        $per = UAuth::getUserPrivileges('user');

        return $per->read == 1 ? true : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $per = UAuth::getUserPrivileges('user');

        return $per->create == 1 ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\user  $model
     * @return mixed
     */
    public function update(User $user, user $model)
    {
        $per = UAuth::getUserPrivileges('user');

        return $per->update == 1 ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\user  $model
     * @return mixed
     */
    public function delete(User $user, user $model)
    {
        $per = UAuth::getUserPrivileges('user');

        return $per->delete == 1 ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\user  $model
     * @return mixed
     */
    public function restore(User $user, user $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\user  $model
     * @return mixed
     */
    public function forceDelete(User $user, user $model)
    {
        //
    }
}
