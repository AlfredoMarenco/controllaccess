<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->string('name')->nullable();
            $table->string('section')->nullable();
            $table->string('price_category')->nullable();
            $table->string('row')->nullable();
            $table->string('seat')->nullable();
            $table->string('amount')->nullable();
            $table->string('order')->nullable();
            $table->string('sales_channel')->nullable();
            $table->string('ext')->nullable();
            $table->enum('status',[0,1,2,3,4,5,6,7,8,9]);
            $table->foreignId('event_id')->constrained();
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
        Schema::dropIfExists('codes');
    }
};
