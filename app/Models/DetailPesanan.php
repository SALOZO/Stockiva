<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanans';

    protected $fillable = [
        'pesanan_id',
        'kategori_id',
        'jenis_id',
        'barang_id',
        'jumlah',
        'harga_satuan',
        'subtotal'
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    // Relasi ke Pesanan
    public function pesanan(){
        return $this->belongsTo(Pesanan::class);
    }

    // Relasi ke Kategori
    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi ke Jenis
    public function jenis(){
        return $this->belongsTo(Jenis::class, 'jenis_id');
    }

    // Relasi ke Barang
    public function barang(){
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
