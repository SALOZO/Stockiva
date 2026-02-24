<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekspedisi extends Model
{
    use HasFactory;
    protected $table = 'ekspedisi';
    protected $fillable = [
        'nama_ekspedisi',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'desa',
        'alamat',
        'nama_pic',
        'no_telp_pic',
        'email_pic',
        'created_by'
    ];

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
