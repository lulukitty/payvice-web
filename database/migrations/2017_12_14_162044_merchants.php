<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Merchants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mht_name', 100)->nullable();
            $table->string('mht_posaddr', 100)->nullable();
            $table->string('mht_addr', 100)->nullable();
            $table->string('mht_email', 100)->nullable();
            $table->string('mht_category', 100)->nullable();
            $table->string('mht_username', 100)->nullable();
            $table->string('mht_code', 255)->nullable();
            $table->string('mht_viceid', 100)->nullable();
            $table->string('mht_bank', 255)->nullable();
            $table->string('mht_tid', 10)->nullable();
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
        Schema::dropIfExists('merchants');
    }
}
