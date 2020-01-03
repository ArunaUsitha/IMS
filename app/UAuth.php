<?php

namespace App;
use Illuminate\Auth\Access\HandlesAuthorization;

class UAuth
{
    static function getUserPrivileges($mod)
    {

        if (auth()->user()) {
            $user = User::find(auth()->user()->id);
            $role = $user->role;
            $role_permissions = $role->permissions()->where('module', $mod)->get();

            return $role_permissions[0]->pivot;

        } else {
            return false;
        }

    }

}
