<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('sale_id');
            $table->string('payment_type')->nullable();
            $table->string('amount')->default(0);
            $table->string('payment_date');
            $table->string('next_payment')->nullable();
            $table->timestamps();
        });
        Schema::table('payments',function (Blueprint $table){
            $table->foreign('sale_id')->references('id')->on('sales');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
