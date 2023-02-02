<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreinvoicesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('preinvoices', function (Blueprint $table) {
            $table->id();
            $table->decimal("price")->index();

            $table->unsignedBigInteger("service_id")->index();
            $table->foreign("service_id")->on('services')->references('id')->onDelete('cascade');

            $table->unsignedBigInteger("mechanic_id")->index();
            $table->foreign("mechanic_id")->on('mechanics')->references('id')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('preinvoices');
    }
}
