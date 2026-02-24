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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();

            $table->string('nama_barang');
            
            // Foreign Keys
            $table->foreignId('kategori_id')->constrained('categories');
            $table->foreignId('jenis_id')->constrained('jenis');
            
            // Relasi ke User (created_by) - opsional
            $table->foreignId('created_by')->nullable()->constrained('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
