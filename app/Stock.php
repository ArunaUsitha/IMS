<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{

    protected $fillable = ['product_id', 'stock'];

    public static function getLowStockProducts()
    {
        //check for low stock item
//        $lowStockProducts = Stock::select()
//            ->join('products', 'stocks.product_id', '=', 'products.id')
//            ->where('stocks.stock', '<=', 'products.reorder_point')
//            ->get()->toArray();


        $lowStockProducts = DB::select(DB::raw('select products.code
                                                        from stocks
                                                                 inner join products on stocks.product_id = products.id
                                                        where stocks.stock <= products.reorder_point'));


        return $lowStockProducts;
    }

}
