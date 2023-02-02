<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUseraddressesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('useraddresses', function (Blueprint $table) {
            $table->id();
            $table->string("street")->nullable();   ////خیابان
            $table->string("alley")->nullable();  /// کوچه
            $table->string("flat")->nullable(); /// ساختمان
            $table->string("detail_address")->nullable(); ////جزیئات آدرس
            $table->decimal("lat")->nullable()->index();
            $table->decimal("lon")->nullable()->index();
            $table->unsignedBigInteger("province_id")->index();
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->unsignedBigInteger("city_id")->index();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->on('users')->references('id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('addressbars');
    }
}
