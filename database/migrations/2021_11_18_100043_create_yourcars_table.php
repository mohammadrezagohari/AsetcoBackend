<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYourcarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yourcars', function (Blueprint $table) {
            $table->id();
            $table->string('pelak')->nullable(); //// شماره پلاک
            $table->bigInteger('year_id')->unsigned()->index();  /// مدل سال خودور
            $table->foreign('year_id')->references('id')->on('years')->cascadeOnDelete();
            $table->bigInteger('color_id')->unsigned()->index();  ///شناسه رنگ خودرو
            $table->foreign('color_id')->references('id')->on('colors')->cascadeOnDelete();
            $table->bigInteger('carmodel_id')->unsigned()->index(); ////
            $table->foreign('carmodel_id')->references('id')->on('carmodels')->cascadeOnDelete();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('yourcars');
    }
}
