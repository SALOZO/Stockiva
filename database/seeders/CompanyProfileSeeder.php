<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('company_profiles')->insert([
            'nama_perusahaan' => 'PT Roland Plays Berkah Jaya Sentosa',
            'alamat' => 'Jl. Contoh No. 123',
            'kelurahan' => 'Sukapura',
            'kecamatan' => 'Kiaracondong',
            'kota' => 'Bandung',
            'provinsi' => 'Jawa Barat',
            'kode_pos' => '40281',
            'telepon' => '022-12345678',
            'email' => 'info@roland.co.id',
            'website' => 'www.roland.co.id',
            'logo' => 'images/13.png',
            'nama_direktur' => 'Nazwan',
            'jabatan_direktur' => 'Direktur Utama',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
