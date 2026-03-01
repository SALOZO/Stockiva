<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SphSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $settings = [
            [
                'key' => 'perihal_default',
                'value' => 'Surat Penawaran Harga',
                'description' => 'Default perihal SPH',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'catatan_ppn',
                'value' => 'Harga belum termasuk PPN 11%',
                'description' => 'Catatan tentang PPN',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'masa_berlaku',
                'value' => '14 (empat belas) hari kalender',
                'description' => 'Masa berlaku penawaran',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'waktu_pengerjaan',
                'value' => '25 hari kalender',
                'description' => 'Waktu pengerjaan',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer_text',
                'value' => 'Demikian Surat Penawaran Harga kami buat berserta lampirannya, agar dapat membantu Bapak/Ibu untuk membuat Keputusan yang tepat. Jika Bapak/Ibu membutuhkan informasi lanjutan, dapat menghubungi kami langsung pada kontak kami yang tertera pada bagian atas. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih',
                'description' => 'Teks penutup SPH',
                'type' => 'textarea',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'nomor_format',
                'value' => 'SPH/{{no_pesanan}}',
                'description' => 'Format nomor SPH (gunakan {{no_pesanan}} sebagai placeholder)',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('sph_settings')->insert($settings);
        
        $this->command->info('Berhasil menambahkan ' . count($settings) . ' data SPH settings!');
    }
}
