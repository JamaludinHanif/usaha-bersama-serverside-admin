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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('role')->nullable();
            $table->string('password')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('otp')->nullable();
            $table->string('is_verify')->default('no');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the miguserrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
