<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_tables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->String("StoreId");
            $table->String("TableName");
            $table->String("TableMaxSeat");
            $table->String("TableStatus");
            $table->String("TableOrder")->nullable();
            $table->String("TableStoreId");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('res_tables');
    }
}
