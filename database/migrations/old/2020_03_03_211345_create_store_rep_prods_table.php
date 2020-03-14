<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreRepProdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_rep_prods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->String('RProdName');
            $table->String("RProdQty");
            $table->String("RProdRepo");
            $table->String("RProdSource");
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_rep_prods');
    }
}
