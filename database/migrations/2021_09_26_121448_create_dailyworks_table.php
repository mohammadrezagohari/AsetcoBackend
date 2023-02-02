<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dailyworks', function (Blueprint $table) {
            $table->id();
            $table->string('day', 20)->index();
            $table->time('from');
            $table->time('to');
            $table->unsignedBigInteger("mechanic_id")->index();
            $table->foreign('mechanic_id')->references('id')->on('mechanics')->onDelete('cascade');
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
        Schema::dropIfExists('dailyworks');
    }
}
