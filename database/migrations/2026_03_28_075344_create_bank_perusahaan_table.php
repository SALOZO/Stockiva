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
        Schema::create('bank_perusahaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bank');         
            $table->string('cabang');             
            $table->string('nomor_rekening');      
            $table->string('atas_nama');           
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_perusahaan');
    }
};
