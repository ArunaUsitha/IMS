<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    public static function getPurchaseOrderDetailsByID($purchase_order_id){

        \Log::info($purchase_order_id);

        $purchase_order = PurchaseOrder::find($purchase_order_id);

        \Log::info($purchase_order);

        $supplier_details = Supplier::find($purchase_order->supplier_id);

        $product_details = purchaseOrderProduct::where('purchase_order_id',$purchase_order_id)
            ->join('products','purchase_order_products.product_id','=','products.id')
            ->get();


        return [
            'purchase_order' => $purchase_order,
            'supplier_details' => $supplier_details,
            'product_details' => $product_details
        ];


    }


    public static function getSupplierDetailByPurchaseOrderID($purchase_order_id){

        $supplierDetails = PurchaseOrder::where('purchase_orders.id',$purchase_order_id)->join('suppliers','purchase_orders.supplier_id','=','suppliers.id')->first();

        return $supplierDetails;

    }
}
