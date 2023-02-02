<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarServicecategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_servicecategory', function (Blueprint $table) {
            $table->unsignedBigInteger("car_id")->index();
            $table->foreign('car_id')->references('id')->on('cars');
            $table->unsignedBigInteger("servicecategory_id")->index();
            $table->foreign('servicecategory_id')->references('id')->on('servicecategories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_servicecategory');
    }
}
