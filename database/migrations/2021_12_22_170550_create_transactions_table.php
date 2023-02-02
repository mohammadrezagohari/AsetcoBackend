<?php

use App\Enums\BankName;
use App\Enums\StatusBank;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedDouble("amount")->index();
            $table->unsignedTinyInteger("bank")->index();  //// Use Enum BankName => BankName::ALL
            $table->string("subject")->nullable();   //// عنوان تراکنش
            $table->string("trace_number")->nullable(); // شماره پیگیری
            $table->string("document_number")->nullable();//// rnn شماره سند
            $table->string("digital_receipt")->nullable();    // رسید دیجیتال
            $table->string("is_suer_bank")->nullable(); // بانک صادرکننده کارت
            $table->string("card_number")->nullable()->index(); // شماره کارت
            $table->string("access_token")->nullable()->index(); //// token که از بانک دریافت می کنیم
            $table->enum("status", StatusBank::ALL)->nullable()->index();
            $table->text("payload")->nullable();///// description text
            $table->unsignedBigInteger("basket_id")->index(); //// equals to invoiceID
            $table->foreign('basket_id')->references('id')->on('baskets');
            $table->timestamps();   //// datepaid update
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
