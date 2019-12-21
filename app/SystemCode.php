<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemCode extends Model
{
    private $productCode;

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




}
