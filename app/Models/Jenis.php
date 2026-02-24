<?php

namespace App\Models;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    use HasFactory;
    protected $table = 'jenis';
    protected $fillable = [
        'name_jenis',
        'kategori_id',
    ];
    public function barang(){
        return $this->hasMany(Barang::class, 'jenis_id');
    }

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
