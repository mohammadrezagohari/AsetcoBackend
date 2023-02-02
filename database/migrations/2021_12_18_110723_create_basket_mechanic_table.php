<?php

use App\Enums\BasketStatusOrder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasketMechanicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basket_mechanic', function (Blueprint $table) {
            $table->enum('status', BasketStatusOrder::ALL)->index();
            $table->bigInteger('mechanic_id')->unsigned()->index();
            $table->foreign('mechanic_id')->references('id')->on('mechanics');
            $table->bigInteger('basket_id')->unsigned()->index();
            $table->foreign('basket_id')->references('id')->on('baskets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basket_mechanic');
    }
}
