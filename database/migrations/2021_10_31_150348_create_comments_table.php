<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('mechanic_id')->unsigned()->index();
            $table->boolean('accepted')->index();
            $table->bigInteger('parent_id')->unsigned()->index();
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('mechanic_id')->on('mechanics')->references('id')->onDelete('cascade');
            $table->text('context');
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
        Schema::dropIfExists('comments');
    }
}
