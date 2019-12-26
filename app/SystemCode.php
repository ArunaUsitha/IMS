<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemCode extends Model
{
    private $productCode;
    private $purchaseOrderCode;

    public function getNewProductCode(){
        $productCodeCount = self::where('module','product')->where('type','productCode')->count();

        if ($productCodeCount == 0){
            //save initial product code
            $this->productCode = '100001';

            $this->saveProductCode();


        }else{
            $data =  self::where('module','product')->where('type','productCode')->get(['last_code','id'])->first();

            $this->productCode = intval($data->last_code) + 1;
            $id = $data->id;

            $this->updateProductCode($id);

        }

        return $this->productCode;

    }


    private function saveProductCode(){

        $productCode = $this->productCode;
        $sysCode = new self();

        $sysCode->module = 'product';
        $sysCode->type = 'productCode';
        $sysCode->last_code = $productCode;

        $sysCode->save();

    }

    private function updateProductCode($id){

        $productCode = $this->productCode;
        $sysCode = self::find($id);

        $sysCode->last_code = $productCode;

        $sysCode->save();

    }












    public function getNewPurchaseOrderCode(){
        $purchaseOrderCodeCount = self::where('module','purchase')->where('type','purchaseOrderCode')->count();

        if ($purchaseOrderCodeCount == 0){
            //save initial product code
            $this->purchaseOrderCode = '100001';

            $this->savePurchaseOrderCode();


        }else{
            $data =  self::where('module','purchase')->where('type','purchaseOrderCode')->get(['last_code','id'])->first();

            $this->purchaseOrderCode = intval($data->last_code) + 1;
            $id = $data->id;

            $this->updatePurchaseOrderCode($id);

        }

        return $this->purchaseOrderCode;

    }


    private function savePurchaseOrderCode(){

        $purchaseOrderCode = $this->purchaseOrderCode;
        $sysCode = new self();

        $sysCode->module = 'purchase';
        $sysCode->type = 'purchaseOrderCode';
        $sysCode->last_code = $purchaseOrderCode;

        $sysCode->save();

    }

    private function updatePurchaseOrderCode($id){

        $purchaseOrderCode = $this->purchaseOrderCode;
        $sysCode = self::find($id);

        $sysCode->last_code = $purchaseOrderCode;

        $sysCode->save();

    }



}
