<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionDetalisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_detalis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id');
            $table->date('lead_date');
            $table->date('payment_date');
            $table->integer('age');
            $table->integer('worker_id');
            $table->integer('payment_method_id');
            $table->integer('check');
            $table->string('check_price');
            $table->integer('amounts_due');
            $table->boolean('payed');
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
        Schema::dropIfExists('transaction_detalis');
    }
}
