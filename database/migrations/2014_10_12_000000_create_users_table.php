<?php

use App\Enums\Gender;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->from(400000);
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile', 11)->unique()->index();
            $table->boolean('activated')->default(0)->index();
            $table->string('national_identity', 10)->nullable()->unique()->index();
            $table->enum('gender', Gender::ALL)->nullable()->index();
            $table->string('password')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
