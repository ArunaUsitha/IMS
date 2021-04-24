<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('initials');
            $table->string('initials_full');
            $table->string('first_name');
            $table->string('last_name')->nullable(true);
            $table->enum('gender',['m','f']);
            $table->string('mobile')->unique();
            $table->string('address_no');
            $table->string('address_street');
            $table->string('address_city');
            $table->string('DOB');
            $table->string('NIC')->unique();
            $table->string('email')->unique();
            $table->string('password');
//            $table->bigInteger('role_id')->unsigned();
            $table->integer('status')->default(1);
            $table->string('profile_img');
//            $table->string('remember_token');
            $table->timestamp('email_verified_at')->nullable();
//            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
