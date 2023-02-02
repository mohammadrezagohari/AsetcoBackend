<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string("card_number", 16)->index();
            $table->string("bank_name");
            $table->string("full_name");
            $table->unsignedBigInteger("user_id")->index();
            $table->foreign('user_id')->on('users')->references('id');
            $table->unsignedBigInteger("payment_id")->index();
            $table->foreign('payment_id')->on('payments')->references('id');
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
        Schema::dropIfExists('cards');
    }
}
