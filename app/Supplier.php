<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public static function getAllActiveSuppliers()
    {
        return Supplier::where('status', 1)->where('is_approved', 1)->get();
    }
}
