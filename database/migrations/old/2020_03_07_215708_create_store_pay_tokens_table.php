<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorePayTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_pay_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->String("ApiSeceret");
            $table->String("ApiPub");
            $table->String("UserId");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_pay_tokens');
    }
}
