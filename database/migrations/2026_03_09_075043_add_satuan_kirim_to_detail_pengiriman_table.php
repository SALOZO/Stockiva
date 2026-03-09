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
        Schema::table('detail_pengiriman', function (Blueprint $table) {
            $table->foreignId('satuan_kirim_id')->nullable()->constrained('satuan_kirim')->after('jumlah_kirim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_pengiriman', function (Blueprint $table) {
            //
        });
    }
};
