<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMechanicaddressesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mechanicaddresses', function (Blueprint $table) {
            $table->id();
            $table->string("street")->nullable();   ////خیابان
            $table->string("alley")->nullable();  /// کوچه
            $table->string("flat")->nullable(); /// ساختمان
            $table->string("detail_address")->nullable(); ////جزیئات آدرس
            $table->unsignedBigInteger("province_id")->index();
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->unsignedBigInteger("city_id")->index();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->bigInteger('mechanic_id')->unsigned()->index();
            $table->foreign('mechanic_id')->on('mechanics')->references('id')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('mechanicaddresses');
    }
}
