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
            $table->string('nama_kurir')->nullable()->after('ekspedisi');
            $table->string('bast_ekspedisi_file')->nullable()->after('no_resi');
            $table->string('bast_client_file')->nullable()->after('bast_ekspedisi_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengiriman', function (Blueprint $table) {
            //
        });
    }
};
