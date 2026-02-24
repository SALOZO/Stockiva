<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'jenis_id',
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
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
