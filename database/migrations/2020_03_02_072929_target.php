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
        if (!Schema::hasTable('target')) {
            Schema::create('target', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->integer('id_sales');
                $table->double('target_omset');
                $table->integer('target_eff_call');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('target_product');
    }
}
