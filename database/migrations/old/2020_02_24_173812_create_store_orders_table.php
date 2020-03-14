<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->String("OrderName");
            $table->String("OrderType");
            $table->Text("OrderCart");
            $table->String("OrderStatus");
            $table->String("OrderPrice");
            $table->String("OrderBy");
            $table->String("OrderPayment");
            $table->String("OrderInf");
            $table->String("OrderStoreId");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_orders');
    }
}
