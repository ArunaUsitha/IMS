<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users(){
        return $this->hasMany('App\User');
    }

    public function permissions(){
        return $this->belongsToMany('App\Permission','role_permissions','role_id','permission_id')->withPivot('create', 'read','update','delete');
    }
}
