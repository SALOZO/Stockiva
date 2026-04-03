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
            $table->string('no_bast')->nullable();
            $table->string('bast_approved_file')->nullable();
            $table->timestamp('bast_approved_at')->nullable();
            $table->foreignId('bast_approved_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengiriman', function (Blueprint $table) {
            $table->dropColumn(['no_bast', 'bast_approved_file', 'bast_approved_at', 'bast_approved_by']);
        });
    }
};
