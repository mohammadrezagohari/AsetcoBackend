<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 200)->index();
            $table->text('description');
            $table->unsignedDouble('price')->index();
            $table->unsignedBigInteger("servicecategory_id")->index();
            $table->foreign('servicecategory_id')->references('id')->on('servicecategories');
            $table->unsignedBigInteger("carmodel_id")->index();
            $table->foreign('carmodel_id')->references('id')->on('carmodels');
            $table->softDeletes();
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
        Schema::dropIfExists('services');
    }
}
