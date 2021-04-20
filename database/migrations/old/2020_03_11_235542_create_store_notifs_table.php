<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreNotifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_notifs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->String("UserId");
            $table->String("NotifStatus");
            $table->String("NotifValue");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_notifs');
    }
}
