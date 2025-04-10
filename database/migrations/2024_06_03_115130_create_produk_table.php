<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->increments('id_produk');
            $table->string('nama_produk', 100);
            $table->decimal('harga', 10, 2);
            $table->unsignedInteger('id_brandproduk');
            $table->foreign('id_brandproduk')->references('id_brandproduk')->on('brandproduk')->onDelete('cascade');
            $table->text('deskripsiproduk');
            $table->string('nama_foto', 50);
            $table->string('folder', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
