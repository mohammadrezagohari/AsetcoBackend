<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitesTable extends Migration
{
    /******************************************
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invites', function (Blueprint $table) {
            $table->id()->from(600000);
            $table->unsignedBigInteger('user_id')->index();
            $table->boolean('accepted')->index();
            $table->string('invited_mobile_number')->index()->nullable();
            $table->string('invited_full_name')->nullable();
            $table->unsignedDouble("price")->nullable()->index();
            $table->unsignedBigInteger('invited_user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /*********************************************
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invites');
    }

}
