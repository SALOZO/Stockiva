<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = [
        'nama_barang',
        'spesifikasi',
        'foto',
        'harga_satuan',
        'kategori_id',
        'jenis_id',
        'satuan_id',
        'created_by'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id');
    }
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'barang_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFotoUrlAttribute(){
    if (!$this->foto) {
        return null;
    }
    
    if (filter_var($this->foto, FILTER_VALIDATE_URL)) {
        return $this->foto;
    }
    
    return Storage::url($this->foto);
    }
    public function getSpesifikasiSingkatAttribute(){
        $panjang = 50;

        if (!$this->spesifikasi) {
            return null;
        }

        return strlen($this->spesifikasi) > $panjang
            ? substr($this->spesifikasi, 0, $panjang) . '...'
            : $this->spesifikasi;
    }

}
