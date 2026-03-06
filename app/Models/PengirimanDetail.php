<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengirimanDetail extends Model
{
    use HasFactory;

    protected $table  = "detail_pesanans";

    protected $fillable = ["pengiriman_id","detail_pesanan_id","jumlah_kirim"];

    public function pengiriman(){
        return $this->belongsTo(Pengiriman::class);
    }
    public function detailPesanan(){
        return $this->belongsTo(DetailPesanan::class, 'detail_pesanan_id');
    }

}
