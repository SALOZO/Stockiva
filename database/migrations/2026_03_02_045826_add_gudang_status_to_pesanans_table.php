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
        Schema::table('pesanans', function (Blueprint $table) {
            $table->enum('gudang_status', [
                'Menunggu',
                'Sedang diproses',        
                'Siap_dikirim',  
                'Dikirim',       
                'Diterima'        
            ])->default('Menunggu')->after('sph_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn('gudang_status');
        });
    }
};
