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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('price')->default(0)->nullable();
            $table->string('unit')->nullable(); // unit adalah satuan dos,pcs,pack, lainnya
            $table->string('category')->nullable(); // category adalah minuman, makanan, pembersih, lainnya
            $table->integer('stock')->nullable();
			$table->bigInteger('weight')->default(0)->nullable();
			$table->bigInteger('length')->default(0)->nullable();
			$table->bigInteger('width')->default(0)->nullable();
			$table->bigInteger('height')->default(0)->nullable();
			$table->longText('description')->nullable();
            $table->string('image')->nullable();
			$table->string('slug')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('products'); // Menghapus seluruh tabel jika dibatalkan
    }
};
