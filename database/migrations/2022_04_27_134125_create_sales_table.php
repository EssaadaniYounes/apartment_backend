<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedTinyInteger('client_id');
            $table->unsignedTinyInteger('property_id');
            $table->date('date_sale');
            $table->integer('advanced_amount')->nullable();
            $table->string('rest')->default(0);
            $table->string('sale_type')->nullable()->default(0);
            $table->string('payment_nature')->default('Partial');
            $table->integer('agreed_amount')->nullable();
            $table->integer('payment_date')->nullable();
            $table->string('monthly_amount')->nullable();
            $table->timestamps();
        });
        Schema::table('sales',function (Blueprint $table){
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('property_id')->references('id')->on('properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
