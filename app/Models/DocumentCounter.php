<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentCounter extends Model
{
    use HasFactory;

    protected $table = 'document_counters';

    protected $fillable = [
        'tahun_bulan',
        'last_number'
    ];

    public static function getNextNumber($tahunBulan = null){
        if (!$tahunBulan) {
            $tahunBulan = now()->format('Y-m');
        }

        $counter = self::firstOrCreate(
            ['tahun_bulan' => $tahunBulan],
            ['last_number' => 0]
        );

        $counter->increment('last_number');

        return $counter->last_number;
    }
}
