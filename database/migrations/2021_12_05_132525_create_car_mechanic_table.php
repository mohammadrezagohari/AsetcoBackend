<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarMechanicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_mechanic', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("car_id")->index();
            $table->foreign('car_id')->references('id')->on('cars');
            $table->unsignedBigInteger("mechanic_id")->index();
            $table->foreign('mechanic_id')->references('id')->on('mechanics');
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
        Schema::dropIfExists('car_mechanic');
    }
}
