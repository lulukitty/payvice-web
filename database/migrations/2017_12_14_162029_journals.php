<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Journals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('term_id', 10);
            $table->string('stan', 100)->nullable();
            $table->string('hPan', 255)->nullable();
            $table->string('mPan', 100)->nullable();
            $table->string('rrn', 100)->nullable();
            $table->string('acode', 100)->nullable();
            $table->string('amount', 20)->nullable();
            $table->string('timestamp', 100)->nullable();
            $table->string('mti', 100)->nullable();
            $table->string('ps', 100)->nullable();
            $table->string('resp', 100)->nullable();
            $table->string('tap', 100)->nullable();
            $table->string('rr', 100)->nullable();
            $table->string('rep', 100)->nullable();
            $table->string('vm', 100)->nullable();
            $table->string('ostan', 100)->nullable();
            $table->string('orrn', 100)->nullable();
            $table->string('oacode', 100)->nullable();
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
        Schema::dropIfExists('journals');
    }
}
