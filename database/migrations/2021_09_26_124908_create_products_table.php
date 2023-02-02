<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 200)->index();
            $table->unsignedDouble('price')->index();
            $table->unsignedBigInteger('carmodel_id')->index();
            $table->foreign('carmodel_id')->on('carmodels')->references('id');
            $table->unsignedBigInteger('year_id')->index();
            $table->foreign('year_id')->on('years')->references('id');
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
        Schema::dropIfExists('products');
    }
}
