<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasketServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basket_service', function (Blueprint $table) {
            $table->boolean("status")->nullable()->index();
            $table->unsignedDouble("price")->nullable()->index();
            $table->unsignedBigInteger("basket_id")->index();
            $table->foreign('basket_id')->references('id')->on('baskets');
            $table->unsignedBigInteger("service_id")->index();
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basket_service');
    }
}
