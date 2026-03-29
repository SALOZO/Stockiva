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
            $table->string('no_invoice')->nullable()->after('no_sph');
            $table->string('invoice_file')->nullable()->after('no_invoice');
            $table->timestamp('invoice_approved_at')->nullable()->after('invoice_file');
            $table->foreignId('invoice_approved_by')->nullable()->constrained('users')->after('invoice_approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            //
        });
    }
};
