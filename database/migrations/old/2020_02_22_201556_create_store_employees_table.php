<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->String("EmployeeName");
            $table->String("EmployeeAge");
            $table->String("EmployeeGender");
            $table->String("EmployeeStatus");
            $table->String("EmployeeFee");
            $table->String("EmployeeDP");
            $table->String("EmployeeMS");
            $table->String("EmployeeStoreId");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_employees');
    }
}
