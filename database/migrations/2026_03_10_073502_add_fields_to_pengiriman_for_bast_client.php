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
        Schema::table('pengiriman', function (Blueprint $table) {
            $table->string('hari_penyerahan')->nullable()->after('penerima_client');
            $table->date('tanggal_penyerahan')->nullable()->after('hari_penyerahan');
            $table->string('jabatan_penerima')->nullable()->after('tanggal_penyerahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengiriman', function (Blueprint $table) {
            $table->dropColumn(['hari_penyerahan', 'tanggal_penyerahan', 'jabatan_penerima']);
        });
    }
};
