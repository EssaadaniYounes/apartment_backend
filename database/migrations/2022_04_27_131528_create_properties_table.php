<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('city');
            $table->unsignedTinyInteger('lodging_id');
            $table->string('space');
            $table->integer('lounge')->default(1);
            $table->integer('room')->default(2);
            $table->integer('toilet')->default(1);
            $table->integer('cuisine')->default(0);
            $table->string('type')->default('apartment');
            $table->string('num_apartment')->nullable()->default('1');
            $table->string('class')->nullable()->default(0);
            $table->string('status')->default('Disponible');
            $table->string('address');
            $table->string('price');
            $table->string('images');
            $table->timestamps();
        });
        Schema::table('properties',function (Blueprint $table){
            $table->foreign('lodging_id')->references('id')->on('lodgings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
