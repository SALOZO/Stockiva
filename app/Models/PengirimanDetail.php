<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengirimanDetail extends Model
{
    use HasFactory;

    protected $table  = "detail_pengiriman";

    protected $fillable = ["pengiriman_id","detail_pesanan_id","jumlah_kirim"];

    public function pengiriman(){
        return $this->belongsTo(Pengiriman::class);
    }
    public function detailPesanan(){
        return $this->belongsTo(DetailPesanan::class, 'detail_pesanan_id');
    }

    public function satuanKirim(){
        return $this->belongsTo(SatuanKirim::class);
    }
    public function ekspedisiRelasi(){
    return $this->belongsTo(Ekspedisi::class, 'ekspedisi_id');
    }

    public function getNamaEkspedisiAttribute(){
        return $this->ekspedisi ?? $this->ekspedisiRelasi->nama_ekspedisi ?? '-';
    }

}
