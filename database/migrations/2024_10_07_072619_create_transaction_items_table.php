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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->nullable();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('product_id')->constrained()->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('price')->nullable();
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
        Schema::dropIfExists('transaction_items');
    }
};
