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
            $table->enum('sph_status', [
                'draft',        // Belum dibuat SPH
                'menunggu',     // SPH dibuat, menunggu approval
                'disetujui',    // Disetujui direktur
                'ditolak'       // Ditolak direktur
            ])->default('draft')->after('status');
            
            // File SPH
            $table->string('sph_file')->nullable()->after('sph_status');
            $table->string('sph_approved_file')->nullable()->after('sph_file');
            
            // Tracking approval
            $table->foreignId('approved_by')->nullable()->constrained('users')->after('sph_approved_file');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('approval_notes')->nullable()->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'sph_status',
                'sph_file',
                'sph_approved_file',
                'approved_by',
                'approved_at',
                'approval_notes'
            ]);
        });
    }
};
