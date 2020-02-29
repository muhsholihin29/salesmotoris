<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Target extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_sales'6);
            $table->integer('id_product',11);
            $table->integer('target',60);
            $table->integer('status',1);         
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
        Schema::dropIfExists('target');
    }
}
