<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('StoreFullName');
            $table->string('StoreUserName')->unique();
            $table->string('StoreEmail')->unique();
            $table->string('StorePassword');
            $table->string('StoreAddress');
            $table->string('PlanType');
            $table->string('PlanDayLeft');
            $table->String('validationToken');
            $table->String('UserStatus');
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
        Schema::dropIfExists('store_users');
    }
}
