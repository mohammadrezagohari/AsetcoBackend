<?php

use App\Enums\BasketStatusOrder;
use App\Enums\DeliveryStep;
use App\Enums\MechanicTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baskets', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('save_step')->nullable()->index(); //// این شماره مرحله رو بر میگردونه
            $table->enum('status', BasketStatusOrder::ALL)->index();//// تمام شده یا در بلاتکلیف
            $table->boolean('i_know_problem')->nullable();   //// من مشکل خودروی خودم رو می دونم
            $table->boolean('serve_product_by_mechanic')->index(); //// محصول توسط مکانیک ارائه شده است یا خیر
            $table->enum('mechanic_type', MechanicTypes::ALL)->index(); /// انتخاب نوع مکانیک
            $table->unsignedBigInteger("problem_id")->nullable()->index(); /// برای تعیین نوع مشکل از جدول مشکلات متدوال
            $table->foreign('problem_id')->references('id')->on('problems');
            $table->unsignedBigInteger("carmodel_id")->nullable()->index();
            $table->foreign('carmodel_id')->references('id')->on('carmodels');
            $table->enum("delivery_step", DeliveryStep::ALL)->default(DeliveryStep::WAIT)->nullable()->index();
            $table->unsignedBigInteger("user_id")->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::dropIfExists('baskets');
    }
}
