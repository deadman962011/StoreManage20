<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->String("ReportName");
            $table->String("ReportType");
            $table->String("ReportOrders");
            $table->String("ReportStoreId");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_reports');
    }
}
