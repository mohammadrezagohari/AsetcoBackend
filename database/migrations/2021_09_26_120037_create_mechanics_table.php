<?php

use App\Enums\MechanicTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMechanicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mechanics', function (Blueprint $table) {
            $table->id();
            $table->enum('type', MechanicTypes::ALL)->index();
            $table->string("full_name", 150)->index()->nullable();
            $table->boolean("parts_supplier")->index()->nullable(); //// تامین کننده قطعه
            $table->string("name", 150)->index()->nullable();
            $table->string("phone", 11)->nullable();
            $table->string("gender", 11)->nullable();
            $table->boolean("supplier")->nullable(); /// تعمین کننده قطعه است یا خیر
            $table->string("license", 20)->nullable();
            $table->string("identity_number", 10)->unique()->nullable();
            $table->string("email")->unique()->nullable();
            $table->boolean("activated")->default(false);
            $table->enum("type_vehicle", \App\Enums\VehicleTypes::ALL)->nullable();///وسیله نقلیه
            $table->string("pelak")->nullable();
            $table->tinyInteger("count_available")->unsigned()->nullable()->index();
            $table->unsignedBigInteger("user_id")->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('mechanics');
    }
}
