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
        Schema::create('paylaters', function (Blueprint $table) {
            $table->id();
            $table->integer('debt_remaining');
            $table->foreignId('user_id');
            $table->foreignId('transaction_id');
            $table->foreignId('interest_id');
            $table->string('status'); // done & unDone
            $table->date('due_date');
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
        Schema::dropIfExists('paylaters');
    }
};
