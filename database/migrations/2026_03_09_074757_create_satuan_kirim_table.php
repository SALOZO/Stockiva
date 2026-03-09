<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('satuan_kirim', function (Blueprint $table) {
            $table->id();
            $table->string('nama_satuan');
            $table->timestamps();
        });

        DB::table('satuan_kirim')->insert([
            ['nama_satuan' => 'Koli', 'created_at' => now(), 'updated_at' => now()],
            ['nama_satuan' => 'Karung', 'created_at' => now(), 'updated_at' => now()],
            ['nama_satuan' => 'Dus', 'created_at' => now(), 'updated_at' => now()],
            ['nama_satuan' => 'Plastik', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satuan_kirim');
    }
};
