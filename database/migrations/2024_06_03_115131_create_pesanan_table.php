<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->increments('id_pesanan');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->enum('status', [
            'Belum Bayar', 
            'Sudah Melakukan Pembayaran', 
            'Menunggu Konfirmasi', 
            'Proses Pengerjaan', 
            'Selesai', 
            'Dibatalkan'
            ]);
            $table->date('tanggalpesanan');
            $table->decimal('totalpesanan', 10, 2);
            $table->string('brand');
            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
