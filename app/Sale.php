<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public static function getPrice($product_id){
        //check default price

        $productPrice  = Product::select('default_price')->where('id',$product_id)->first();


        if ($productPrice->default_price == 0.00){
            $product = purchaseProducts::select('sell_price')->where('product_id',$product_id)->orderBy('created_at','DESC')->first();
            return $product->sell_price;
        }else{
            return $productPrice->default_price;
        }

    }
}
