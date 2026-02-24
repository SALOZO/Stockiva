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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            // DATA PERUSAHAAN
            $table->string('nama_client');
            $table->string('provinsi');
            $table->string('kabupaten_kota');
            $table->string('kecamatan');
            $table->string('desa');
            $table->text('alamat');
            
            // Data PIC (1 Client 1 PIC)
            $table->string('nama_pic');
            $table->string('jabatan_pic');
            $table->string('email_pic')->nullable();
            $table->string('no_telp_pic')->nullable();
            
            // Relasi dengan users (created_by)
            $table->foreignId('created_by')->nullable()->constrained('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
