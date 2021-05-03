<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

    const RESERVATION_HOLD_STATUS = 'hold';
    const RESERVATION_COMPLETED_STATUS = 'completed';
    const RESERVATION_CANCELLED_STATUS = 'cancelled';

    public static function reserve($sales_order_no, $product_id, $count, $customer_id)
    {

//        try {

            if (!self::checkReserved($sales_order_no, $product_id, $customer_id)) {
                $reservation = new Reservation();

                $reservation->sales_order_id = $sales_order_no;
                $reservation->product_id = $product_id;
                $reservation->count = $count;
                $reservation->customer_id = $customer_id;
                $reservation->status = self::RESERVATION_HOLD_STATUS;

                $reservation->save();
                return true;
            } else {

                Reservation::where('sales_order_id', $sales_order_no)
                    ->where('product_id', $product_id)
                    ->where('customer_id', $customer_id)
                    ->where('status', self::RESERVATION_HOLD_STATUS)
                    ->update(['count' => $count]);

                return true;

            }
//        } catch (\Exception  $e) {
//            return false;
//        }


    }

    public static function checkReserved($sales_order_id, $product_id, $customer_id)
    {
        $reservations = Reservation::select('id')
            ->where('sales_order_id', $sales_order_id)
            ->where('product_id', $product_id)
            ->where('customer_id', $customer_id)
            ->where('status', self::RESERVATION_HOLD_STATUS)
            ->count('id');



        if ($reservations > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function getStatus()
    {

    }

    public static function complete($sales_order_id,$sales_id,$product_id,$customer_id)
    {
        return Reservation::where('product_id', $product_id)
            ->where('customer_id', $customer_id)
            ->where('sales_order_id', $sales_order_id)
            ->where('status', self::RESERVATION_HOLD_STATUS)
            ->update([
                'status' => self::RESERVATION_COMPLETED_STATUS,
                'sales_id' => $sales_id
                ]);
    }

    public static function cancel($product_id,$customer_id)
    {

       return Reservation::where('product_id', $product_id)
            ->where('customer_id', $customer_id)
            ->where('status', self::RESERVATION_HOLD_STATUS)
            ->update(['status' => self::RESERVATION_CANCELLED_STATUS]);

    }

    public static function getHoldCount($product_id){

        $result = Reservation::where('product_id',$product_id)
            ->where('status',self::RESERVATION_HOLD_STATUS)
            ->select(\DB::raw('SUM(count) as count'))
                ->groupBy('product_id')
                ->first();

        if($result){
            return $result->count;
        }else{
            return 0;
        }



    }
}
