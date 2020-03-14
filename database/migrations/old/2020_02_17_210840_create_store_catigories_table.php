<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreCatigoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_catigories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->String('CatigoryName');
            $table->String('CatigoryProdsNum');
            $table->String('CatigoryStoreId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_catigories');
    }
}
