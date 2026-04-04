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
            $table->string('kwitansi_file')->nullable();
            $table->string('kwitansi_approved_file')->nullable();
            $table->timestamp('kwitansi_approved_at')->nullable();
            $table->foreignId('kwitansi_approved_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn([
                'kwitansi_file', 'kwitansi_approved_file',
                'kwitansi_approved_at', 'kwitansi_approved_by'
            ]);
        });
    }
};
