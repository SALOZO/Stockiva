<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankPerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bank_perusahaan')->insert([
            [
                'nama_bank' => 'Bank Mandiri',
                'cabang' => 'KCP Buahbatu',
                'nomor_rekening' => '130 00 551 1',
                'atas_nama' => 'PT Roland Plays',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
