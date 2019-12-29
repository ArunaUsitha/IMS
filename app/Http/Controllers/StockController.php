<?php

namespace App\Http\Controllers;

use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function viewStock(){
       return view('admin.stocks.overview');
    }

    public function getAllStocks(){
        $stocks  = DB::table('stocks')
            ->join('products', 'stocks.product_id', '=', 'products.id')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->select('stocks.*','product_categories.name as category_name','products.*')
            ->get();

        return response()->json(['stock'=>$stocks]);
    }
}
