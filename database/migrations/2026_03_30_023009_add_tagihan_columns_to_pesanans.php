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
            $table->string('no_tagihan')->nullable()->after('no_invoice');
            $table->string('tagihan_file')->nullable()->after('no_tagihan');
            $table->string('tagihan_approved_file')->nullable()->after('tagihan_file');
            $table->timestamp('tagihan_approved_at')->nullable()->after('tagihan_approved_file');
            $table->foreignId('tagihan_approved_by')->nullable()->constrained('users')->after('tagihan_approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn([
                'no_tagihan', 'tagihan_file',
                'tagihan_approved_file', 'tagihan_approved_at', 'tagihan_approved_by'
            ]);
        });
    }
};
