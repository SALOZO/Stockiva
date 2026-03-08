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
            $table->foreignId('ekspedisi_id')->nullable()->constrained('ekspedisi')->after('ekspedisi');
            $table->string('kurir_no_telp')->nullable()->after('nama_kurir');
            $table->string('kurir_jenis_identitas')->nullable()->after('kurir_no_telp');
            $table->string('kurir_no_identitas')->nullable()->after('kurir_jenis_identitas');
            $table->string('kurir_plat_nomor')->nullable()->after('kurir_no_identitas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengiriman', function (Blueprint $table) {
        $table->dropForeign(['ekspedisi_id']);
            $table->dropColumn([
                'ekspedisi_id',
                'kurir_no_telp',
                'kurir_jenis_identitas',
                'kurir_no_identitas',
                'kurir_plat_nomor'
            ]);
        });
    }
};
