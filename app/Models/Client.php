<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = [
        'nama_client',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'desa',
        'alamat',
        'nama_pic',
        'jabatan_pic',
        'email_pic',
        'no_telp_pic',
        'created_by'
    ];

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pesanans()    {
        return $this->hasMany(Pesanan::class);
    }
}
