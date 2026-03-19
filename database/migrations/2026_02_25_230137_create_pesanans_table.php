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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pesanan')->unique(); // Nomor pesanan unik
            $table->string('no_sph')->nullable();
            $table->foreignId('client_id')->constrained('clients');
            $table->date('tanggal_pesanan');
            $table->enum('status', ['baru', 'diproses', 'selesai', 'dibatalkan'])->default('baru');
            $table->decimal('total_keseluruhan', 15, 2)->default(0);
            $table->timestamp('ready_for_gudang_at')->nullable();
            $table->boolean('is_ready_for_gudang')->default(false);
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
