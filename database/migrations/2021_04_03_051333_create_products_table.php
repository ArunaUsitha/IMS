<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',50);
            $table->string('custom_code')->nullable(true);
            $table->string('name',50);
            $table->bigInteger('product_category_id')->unsigned();
            $table->bigInteger('brand_id',false,true)->nullable(true);
            $table->string('model_no')->nullable(true);
            $table->string('description')->nullable(true);
            $table->string('barcode')->nullable(true);
            $table->integer('reorder_point')->default(10);
            $table->integer('reorder_quantity')->default(10);
            $table->decimal('special_price',10,2)->nullable(true);
            $table->integer('status')->default(1);
            $table->timestamps();


            $table->unique(['name','code']);

            //foreign key
            $table->foreign('product_category_id')->references('id')->on('product_categories');
            $table->foreign('brand_id')->references('id')->on('brands');




        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
