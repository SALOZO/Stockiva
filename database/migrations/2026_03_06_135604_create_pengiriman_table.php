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
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            $table->string('no_pengiriman')->unique();
            $table->integer('pengiriman_ke');
            $table->date('tanggal');
            $table->enum('status', ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('pending');
            // $table->string('penerima_ekspedisi')->nullable();
            $table->string('penerima_client')->nullable();
            $table->string('ekspedisi')->nullable();
            // $table->string('no_resi')->nullable();
            $table->datetime('tanggal_kirim')->nullable();
            $table->datetime('tanggal_terima')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};
