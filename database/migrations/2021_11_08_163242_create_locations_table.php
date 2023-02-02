<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->decimal('lat', 8, 5)->index();
            $table->decimal('lon', 8, 5)->index();
            $table->tinyInteger('support_space')->unsigned()->index();
            $table->unsignedBigInteger('mechanic_id')->index();
            $table->enum('type', \App\Enums\LocationType::ALL)->index();
            $table->foreign('mechanic_id')->on('mechanics')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('locations');
    }
}
