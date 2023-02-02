<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMechanicServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mechanic_service', function (Blueprint $table) {
            $table->id();
            $table->boolean("status")->index()->nullable();
            $table->unsignedBigInteger("price")->index()->nullable();
            $table->unsignedBigInteger("service_id")->index();
            $table->foreign('service_id')->references('id')->on('services');
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
        Schema::dropIfExists('mechanic_service');
    }
}
