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
        Schema::create('ekspedisi', function (Blueprint $table) {
            $table->id();

            // Data Perusahaan Ekspedisi
            $table->string('nama_ekspedisi');
            $table->string('provinsi');
            $table->string('kabupaten_kota');
            $table->string('kecamatan');
            $table->string('desa');
            $table->text('alamat');
            
            // Data PIC Ekspedisi (1 Ekspedisi 1 PIC)
            $table->string('nama_pic');
            $table->string('no_telp_pic');

            // Relasi ke User (created_by)
            $table->foreignId('created_by')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekspedisi');
    }
};
