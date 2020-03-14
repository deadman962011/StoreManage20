<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreReposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_repos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->String("RepoName");
            $table->String("RepoAddress");
            $table->String("RepoStoreId");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_repos');
    }
}
