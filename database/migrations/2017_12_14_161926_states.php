<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class States extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->string('serial', 100)->nullable();
            $table->string('ctime', 100)->nullable();
            $table->string('bl', 100)->nullable();
            $table->string('cs', 100)->nullable();
            $table->string('ps', 100)->nullable();
            $table->string('tid', 10)->unique();
            $table->string('coms', 100)->nullable();
            $table->string('cloc', 255)->nullable();
            $table->string('tmn', 100)->nullable();
            $table->string('tmanu', 100)->nullable();
            $table->string('hb', 100)->nullable();
            $table->string('sv', 100)->nullable();
            $table->string('lTxnAt', 100)->nullable();
            $table->string('pads', 100)->nullable();
            $table->string('appName', 100)->nullable();
            $table->string('appVersion', 100)->nullable();
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
        Schema::dropIfExists('states');
    }
}
