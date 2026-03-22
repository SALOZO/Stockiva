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
            $table->enum('keuangan_status', ['pending', 'proses', 'lunas'])->default('pending')->after('is_ready_for_gudang');
            $table->timestamp('keuangan_at')->nullable()->after('keuangan_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['keuangan_status', 'keuangan_at']);
        });
    }
};
