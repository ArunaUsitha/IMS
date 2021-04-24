<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('title',['Mr','Mrs','Miss'])->nullable(true);
            $table->string('initials');
            $table->string('first_name');
            $table->string('last_name')->nullable(true);
            $table->enum('gender',['m','f']);
            $table->string('mobile',15);
            $table->string('address_no');
            $table->string('address_street');
            $table->string('address_city');
            $table->string('email',50)->nullable(true);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
