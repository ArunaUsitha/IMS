<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function productCategory()
    {
        return $this->belongsTo('App\ProductCategory');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }


}
