<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenKontrak extends Model
{
    use HasFactory;

    protected $table = 'dokumen_kontrak';

    protected $fillable = [
        'pesanan_id',
        'jenis',
        'nomor_kontrak',
        'tanggal_kontrak',
        'file_path',
        'input_by'
    ];

    protected $casts = [
        'tanggal_kontrak' => 'date'
    ];

    public function pesanan(){
        return $this->belongsTo(Pesanan::class);
    }

    public function inputBy(){
        return $this->belongsTo(User::class, 'input_by');
    }
}
