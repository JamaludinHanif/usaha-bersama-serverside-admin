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
        Schema::create('payment_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('type'); // cash & paylater
            $table->string('type_sending');
            // $table->string('path_invoice');
            $table->string('status'); // succes & failed & pending
            $table->integer('amount');
            $table->foreignId('transaction_id');
            $table->foreignId('user_id');
            $table->foreignId('cashier_id')->nullable();
            $table->foreignId('interest_id')->nullable();
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
        Schema::dropIfExists('payment_codes');
    }
};
